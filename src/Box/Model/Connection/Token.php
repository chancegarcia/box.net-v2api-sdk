<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Connection\Token;
use Box\Model\Connection\Response;

class Token
{
    CONST TOKEN_URI = "https://www.box.com/api/oauth2/token";

    protected $_grantType = "authorization_code";
    protected $_code;
    protected $_clientId;
    protected $_clientSecret;
    protected $_redirectUri;
    protected $_refreshToken;
    protected $_deviceId;
    protected $_deviceName;

    // json response
    protected $_response;

    // all parameters must be url encoded

}
