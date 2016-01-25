<?php
/**
 * @package     Box
 * @subpackage  Box_Exception
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 */

namespace Box\Exception;

class BoxException extends \Exception
{

    const INVALID_CLASS_TYPE = "Invalid Class Type";
    const UNKNOWN_CLASS = "Unknown Class";
    const INVALID_CLASS = "Invalid Class";
    const INVALID_INPUT = "Invalid Input";
    const MISSING_ID = "Missing Id";

    protected $error;
    protected $errorDescription;
    protected $context = array();
    protected $boxCode;

    public function setError($error = null)
    {
        $this->error = $error;
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setErrorDescription($errorDescription = null)
    {
        $this->errorDescription = $errorDescription;
        return $this;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    public function addContext($contextInformation = null, $key = null)
    {
        if (is_string($key))
        {
            $finalKey = $key;
            // if we have duplicate key for some reason, make it unique
            if (array_key_exists($key, $this->context))
            {
                do
                {
                    $finalKey = uniqid($key . "_");
                }
                while (array_key_exists($finalKey, $this->context));
            }

            $this->context[$finalKey] = $contextInformation;
        }
        else
        {
            $this->context[] = $contextInformation;
        }
    }

    public function getContext($key = null)
    {
        // make sure we have a key value and avoid false negative; allow null to returned on non-existent key
        if (!is_null($key))
        {
            if (array_key_exists($key, $this->context))
            {
                return $this->context[$key];
            }
            else
            {
                return null;
            }
        }

        // if provided a null key, we return full context
        return $this->context;
    }

    /**
     * @return mixed
     */
    public function getBoxCode()
    {
        return $this->boxCode;
    }

    /**
     * @param mixed $boxCode
     * @return BoxException
     */
    public function setBoxCode($boxCode = null)
    {
        $this->boxCode = $boxCode;
        return $this;
    }
}
