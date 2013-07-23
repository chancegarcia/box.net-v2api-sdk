<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 *
 * connection assumes a valid access token
 */

namespace Box\Model\Connection;
use Box\Model;
use Box\Exception;
use Box\Model\Connection\Token\TokenInterface;

class Connection extends Model implements ConnectionInterface
{

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


    // relooking over auth flow, we have to assume app is already authorized externally. rewrite to use tokens for connection
    // may need to store the tokens
    public function connect()
    {

    }

    /**
     * GET
     * @param $uri
     * @return mixed
     */
    public function query($uri)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * POST
     * @param       $uri
     * @param array $params
     * @return mixed
     */
    public function post($uri,array $params = array())
    {
        if (!is_array($params))
        {
            throw new Exception("params must be an array",Exception::INVALID_INPUT);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }



    public function setClientId($clientId = null)
    {
        $this->_clientId = $clientId;
        return $this;
    }

    public function getClientId()
    {
        return $this->_clientId;
    }

    public function setClientSecret($clientSecret = null)
    {
        $this->_clientSecret = $clientSecret;
        return $this;
    }

    public function getClientSecret()
    {
        return $this->_clientSecret;
    }

    public function setRedirectUri($redirectUri = null)
    {
        $this->_redirectUri = $redirectUri;
        return $this;
    }

    public function getRedirectUri()
    {
        return $this->_redirectUri;
    }

    public function setRequestType($requestType = null)
    {
        $this->_requestType = $requestType;
        return $this;
    }

    public function getRequestType()
    {
        return $this->_requestType;
    }

    public function setResponse($response = null)
    {
        $this->_response = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function setResponseType($responseType = null)
    {
        $this->_responseType = $responseType;
        return $this;
    }

    public function getResponseType()
    {
        return $this->_responseType;
    }

    public function setState($state = null)
    {
        $this->_state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->_state;
    }

}
