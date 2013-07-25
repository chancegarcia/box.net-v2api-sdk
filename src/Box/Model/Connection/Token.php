<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
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

    // all parameters must be url encoded

}
