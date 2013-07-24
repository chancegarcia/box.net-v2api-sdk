<?php
/**
 * @package     Box
 * @subpackage  Box_Model
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box;

use Box\Exception;
use Box\Model\Connection;
use Box\Model\File;
use Box\Model\Folder;
use Box\Model\Connection\Response;

class Model
{
    /**
     * @param string $class
     * @param  string $classType
     * @throws \Box\Exception
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
        $query = http_build_query($params,$numericPrefix,'&', PHP_QUERY_RFC3986);
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
}
