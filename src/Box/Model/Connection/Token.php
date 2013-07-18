<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Connection\Token;

class Token
{
    CONST TOKEN_URI = "https://www.box.com/api/oauth2/token";

    protected $_grantType = "authorization_code";
    protected $_code;
    protected $_clientId;
    protected $_clientSecret;
    protected $_redirectUri;

    // json response
    protected $_accessToken;
    protected $_expiresIn;
    protected $_tokenType;
    protected $_refreshToken;
    protected $_error;
    protected $_errorDescription;

    // all parameters must be url encoded

}
