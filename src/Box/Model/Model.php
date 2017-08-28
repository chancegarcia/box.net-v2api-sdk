<?php
/**
 * @package        Box
 * @subpackage     Box_Model
 * @author         Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 *    The MIT License (MIT)
 *
 * Copyright (c) 2013-2016 Chance Garcia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

namespace Box\Model;

use Box\Exception\BoxException;
use Box\Http\Response\BoxResponseInterface;
use Psr\Log\LoggerInterface;

class Model extends BaseModel implements ModelInterface
{

    // @todo add curl history on info/error/errno properties for child classes to access for recording
    // @todo add last curl info/error/errno properties as well

    public function __construct(array $options = null)
    {

        if (null !== $options)
        {
            $this->mapBoxToClass($options);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function classArray()
    {
        $aModel = get_object_vars($this);
        $aArray = array();

        foreach ($aModel as $k => $v)
        {
            $sKey = $this->toBoxVar($k);
            $aArray[ $sKey ] = $v;
        }

        return $aArray;
    }

    /**
     * {@inheritdoc}
     */
    public function toBoxArray()
    {
        $arr = $this->classArray();

        $finalArray = $this->removeEmpty($arr);

        return $finalArray;
    }

    /**
     * used to throw exceptions that need to contain error information returned from Box
     *
     * @param $data array containing error and error_description keys
     *
     * @throws \Box\Exception\BoxException
     */
    public function error($data, $message = null, BoxResponseInterface $boxResponse = null)
    {
        $error = $data['error'];
        if (null === $message || !is_string($message))
        {
            $message = $error;
        }

        $exception = new BoxException($message);
        $exception->setError($error);
        $exception->setErrorDescription($data['error_description']);

        if ($boxResponse instanceof BoxResponseInterface) {
            $exception->setBoxResponse($boxResponse);
        }

        throw $exception;
    }

    public function debug($message, $context = [])
    {
        if ($this->getLogger() instanceof LoggerInterface) {
            $this->getLogger()->debug($message, $context);
        }
    }

    /**
     * @param string $class
     * @param  string $classType
     *
     * @throws \Box\Exception\BoxException
     * @return bool returns true if validation passes. Throws exception if unable to validate or validation doesn't pass
     */
    public function validateClass($class, $classType)
    {
        if (!is_string($class))
        {
            throw new BoxException("Please specify a class string to validate", BoxException::INVALID_INPUT);
        }

        if (!is_string($classType))
        {
            throw new BoxException("Unable to validate. Please specify a class type to validate",
                                   BoxException::INVALID_CLASS_TYPE);
        }

        if (!class_exists($class))
        {
            throw new BoxException("Unable to find class", BoxException::UNKNOWN_CLASS);
        }
        else
        {
            $oClass = new $class();
        }

        if (!$oClass instanceof $classType)
        {
            throw new BoxException("Invalid Connection Class", BoxException::INVALID_CLASS_TYPE);
        }

        return true;
    }

    public function buildQuery($params, $numericPrefix = null)
    {

        if (version_compare(PHP_VERSION, '5.4.0', '>='))
        {
            $query = http_build_query($params, $numericPrefix, '&', PHP_QUERY_RFC3986);
        }
        else
        {
            $pleaseUpgradeTo54 = array();
            foreach ($params as $k => $v)
            {
                $pleaseUpgradeTo54[ $k ] = urlencode($v);
            }
            $query = http_build_query($pleaseUpgradeTo54, $numericPrefix, '&');
            @trigger_error('upgrade to at least php 5.4.0; this will be deprecated in the future', E_USER_DEPRECATED);
        }

        return $query;
    }

    public function getNewClass($className = null, $classConstructorOptions = null)
    {
        if (null === $className)
        {
            throw new BoxException('undefined class name', BoxException::INVALID_INPUT);
        }

        $sMethod = 'get' . ucfirst($className) . 'Class';

        $sClass = $this->$sMethod();

        $oClass = new $sClass($classConstructorOptions);

        return $oClass;
    }
}
