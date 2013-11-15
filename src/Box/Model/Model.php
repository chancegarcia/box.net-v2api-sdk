<?php
/**
 * @package     Box
 * @subpackage  Box_Model
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model;

use Box\Exception\Exception;

class Model
{

    public function __construct($options = null){

            if (null !== $options)
            {
                foreach ($options as $k=>$v)
                {
                    $method = 'set' . ucfirst($this->toClassVar($k));
                    if (method_exists($this,$method))
                    {
                        $this->$method($v);
                    }
                }
            }

            return $this;
        }

    public function toArray()
    {
        $aModel = get_object_vars($this);
        $aArray = array();

        foreach ($aModel as $k => $v)
        {
            $sKey = $this->toBoxVar($k);
            $aArray[$sKey] = $v;
        }

        return $aArray;
    }

    /**
     * used to throw exceptions that need to contain error information returned from Box
     * @param $data array containing error and error_description keys
     * @throws \Box\Exception\Exception
     */
    public function error($data)
    {
        $exception = new \Box\Exception\Exception($data['error']);
        $exception->setError($data['error']);
        $exception->setErrorDescription($data['error_description']);
        throw $exception;
    }

    /**
     * @param string $class
     * @param  string $classType
     * @throws \Box\Exception\Exception
     * @return bool returns true if validation passes. Throws exception if unable to validate or validation doesn't pass
     */
    public function validateClass($class,$classType)
    {
        if (!is_string($class))
        {
            throw new Exception("Please specify a class string to validate",Exception::INVALID_INPUT);
        }

        if (!is_string($classType))
        {
            throw new Exception("Unable to validate. Please specify a class type to validate",Exception::INVALID_CLASS_TYPE);
        }

        if (!class_exists($class))
        {
            throw new Exception("Unable to find class" , Exception::UNKNOWN_CLASS);
        }
        else
        {
            $oClass = new $class();
        }

        if (!$oClass instanceof $classType)
        {
            throw new Exception("Invalid Connection Class" , Exception::INVALID_CLASS_TYPE);
        }

        return true;
    }

    public function buildQuery($params,$numericPrefix=null)
    {

        if (version_compare(PHP_VERSION, '5.4.0', '>='))
        {
            $query = http_build_query($params , $numericPrefix , '&' , PHP_QUERY_RFC3986);
        }
        else
        {
            $pleaseUpgradeTo54 = array();
            foreach($params as $k=>$v)
            {
                $pleaseUpgradeTo54[$k]=urlencode($v);
            }
            $query = http_build_query($pleaseUpgradeTo54,$numericPrefix,'&');
        }
        return $query;
    }

    public function toClassVar($str) {
        $aTokens = explode("_",$str);
        $sFirst = array_shift($aTokens);
        $aTokens = array_map('ucfirst',$aTokens);
        array_unshift($aTokens,$sFirst);
        $classVar = implode("",$aTokens);
        return $classVar;
    }

    public function toBoxVar($str)
    {
        $aTokens = preg_split('/(?<=\\w)(?=[A-Z])/', $str);
        $sFirst = array_shift($aTokens);
        $aTokens = array_map('lcfirst',$aTokens);
        array_unshift($aTokens,$sFirst);
        $boxVar = implode("_",$aTokens);
        return $boxVar;
    }

    /**
     * this will bomb out if any properties are private
     * @todo try using setter if found?
     * @param $aData
     * @return $this
     */
    public function mapBoxToClass($aData)
    {
        foreach ($aData as $k=>$v)
        {
            $sClassProp = $this->toClassVar($k);
            $sSetterMethod = "set" . ucfirst($sClassProp);
            if (method_exists($this, $sSetterMethod))
            {
                $this->{$sSetterMethod}($v);
            } else {
                $this->{$sClassProp} = $v;
            }
        }

        return $this;
    }

    public function getNewClass($className = null, $classConstructorOptions = null)
    {
        if (null === $className)
        {
            throw new Exception('undefined class name', Exception::INVALID_INPUT);
        }

        $sMethod = 'get' . ucfirst($className) . 'Class';

        $sClass = $this->$sMethod();

        $oClass = new $sClass($classConstructorOptions);

        return $oClass;
    }
}
