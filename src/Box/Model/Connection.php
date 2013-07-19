<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Connection;
use Box\Model;
use Box\Exception;

class Connection extends Model implements ConnectionInterface
{

    CONST AUTH_URL = "https://www.box.com/api/oauth2/authorize";

    protected $_responseType = "code";
    protected $_clientId;
    protected $_clientSecret;
    protected $_redirectUri;
    protected $_state;
    protected $_requestType = "GET";

    protected $_response;
    protected $_responseClass;

    public function setResponseClass($responseClass = null)
    {
        $this->validateClass($responseClass,'ResponseInterface');
        $this->_responseClass = $responseClass;
        return $this;
    }

    public function getResponseClass()
    {
        return $this->_responseClass;
    }



    public function connect()
    {

    }

}
