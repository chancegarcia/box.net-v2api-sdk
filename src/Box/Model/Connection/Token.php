<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Connection\Token;
use Box\Model\Connection\Response;
use Box\Model;

class Token extends Model implements TokenInterface
{

    protected $_accessToken;
    protected $_refreshToken;
    protected $_grantType = "authorization_code";
    protected $_expiresIn;
    protected $_tokenType;

    public function setExpiresIn($expiresIn = null)
    {
        $this->_expiresIn = $expiresIn;
        return $this;
    }

    public function getExpiresIn()
    {
        return $this->_expiresIn;
    }

    public function setTokenType($tokenType = null)
    {
        $this->_tokenType = $tokenType;
        return $this;
    }

    public function getTokenType()
    {
        return $this->_tokenType;
    }



    public function setAccessToken($accessToken = null)
    {
        $this->_accessToken = $accessToken;
        return $this;
    }

    public function getAccessToken()
    {
        return $this->_accessToken;
    }


    public function setGrantType($grantType = null)
    {
        $this->_grantType = $grantType;
        return $this;
    }

    public function getGrantType()
    {
        return $this->_grantType;
    }

    public function setRefreshToken($refreshToken = null)
    {
        $this->_refreshToken = $refreshToken;
        return $this;
    }

    public function getRefreshToken()
    {
        return $this->_refreshToken;
    }

    // all parameters must be url encoded

}
