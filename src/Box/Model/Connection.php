<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model;
use Box\Exception;

class Connection
{

    CONST AUTH_URL = "https://www.box.com/api/oauth2/authorize";

    protected $_responseType = "code";
    protected $_clientId;
    protected $_redirectUri;
    protected $_state;
    protected $_requestType = "POST";
    protected $_response;
    protected $_responseError;
    protected $_responseErrorDescription;


}
