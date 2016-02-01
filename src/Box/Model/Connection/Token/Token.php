<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
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

namespace Box\Model\Connection\Token;
use Box\Model\Connection\Response;
use Box\Model\Model;

class Token extends Model implements TokenInterface
{
    protected $accessToken;
    protected $refreshToken;
    protected $grantType = "authorization_code";
    protected $expiresIn;
    protected $tokenType;
    protected $restrictedTo = array();

    public function setExpiresIn($expiresIn = null)
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function setTokenType($tokenType = null)
    {
        $this->tokenType = $tokenType;
        return $this;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }



    public function setAccessToken($accessToken = null)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }


    public function setGrantType($grantType = null)
    {
        $this->grantType = $grantType;
        return $this;
    }

    public function getGrantType()
    {
        return $this->grantType;
    }

    public function setRefreshToken($refreshToken = null)
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getRestrictedTo()
    {
        return $this->restrictedTo;
    }

    /**
     * {@inheritdoc}
     */
    public function setRestrictedTo($restrictedTo = null)
    {
        $this->restrictedTo = $restrictedTo;

        return $this;
    }

    // all parameters must be url encoded

}
