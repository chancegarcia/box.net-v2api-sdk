<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
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
