<?php
/**
 * @package     Box
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box;

class Exception
    extends \Exception
{

    const INVALID_CLASS_TYPE = "Invalid Class Type";
    const UNKNOWN_CLASS = "Unknown Class";
    const INVALID_CLASS = "Invalid Class";
    const INVALID_INPUT = "Invalid Input";

    protected $_error;
    protected $_errorDescription;

    public function setError($error = null)
    {
        $this->_error = $error;
        return $this;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function setErrorDescription($errorDescription = null)
    {
        $this->_errorDescription = $errorDescription;
        return $this;
    }

    public function getErrorDescription()
    {
        return $this->_errorDescription;
    }


}
