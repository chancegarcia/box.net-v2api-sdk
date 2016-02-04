<?php
/**
 * @package     Box
 * @subpackage  Box_Exception
 * @author      Chance Garcia
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

    public function setError($error = null) {
        $this->error = $error;

        return $this;
    }

    public function getError() {
        return $this->error;
    }

    public function setErrorDescription($errorDescription = null) {
        $this->errorDescription = $errorDescription;

        return $this;
    }

    public function getErrorDescription() {
        return $this->errorDescription;
    }

    public function addContext($contextInformation = null, $key = null) {
        if (is_string($key)) {
            $finalKey = $key;
            // if we have duplicate key for some reason, make it unique
            if (array_key_exists($key, $this->context)) {
                do {
                    $finalKey = uniqid($key."_");
                } while (array_key_exists($finalKey, $this->context));
            }

            $this->context[$finalKey] = $contextInformation;
        } else {
            $this->context[] = $contextInformation;
        }
    }

    public function getContext($key = null) {
        // make sure we have a key value and avoid false negative; allow null to returned on non-existent key
        if (!is_null($key)) {
            if (array_key_exists($key, $this->context)) {
                return $this->context[$key];
            } else {
                return null;
            }
        }

        // if provided a null key, we return full context
        return $this->context;
    }

    /**
     * @return mixed
     */
    public function getBoxCode() {
        return $this->boxCode;
    }

    /**
     * @param mixed $boxCode
     * @return BoxException
     */
    public function setBoxCode($boxCode = null) {
        $this->boxCode = $boxCode;

        return $this;
    }
}
