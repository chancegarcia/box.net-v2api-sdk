<?php
/**
 * @package     Box
 * @subpackage Box_Exception
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

    public function addContext($contextInformation = null)
    {
        $this->context[] = $contextInformation;
    }
}
