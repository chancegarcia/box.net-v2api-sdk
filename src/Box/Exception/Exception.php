<?php
/**
 * @package     Box
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Exception;

@trigger_error('The '.__NAMESPACE__.'\Exception class is deprecated. Please start catching BoxException; this is still in use by the Client Class which is planned to be deprecated in the future.', E_USER_DEPRECATED);
/**
 * Class Exception
 * @package Box\Exception
 * @deprecated Please start catching BoxException; this is still in use by the Client Class which is planned to be deprecated in the future
 */
class Exception extends \Exception
{

    const INVALID_CLASS_TYPE = "Invalid Class Type";
    const UNKNOWN_CLASS = "Unknown Class";
    const INVALID_CLASS = "Invalid Class";
    const INVALID_INPUT = "Invalid Input";
    const MISSING_ID = "Missing Id";

    protected $error;
    protected $errorDescription;

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
}
