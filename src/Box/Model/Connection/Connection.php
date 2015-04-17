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
use Box\Model\Model;
use Box\Exception\Exception;
use Box\Model\Connection\Token\TokenInterface;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Response\ResponseInterface;
use Box\Model\Connection\Response\Response;
use \CURLFile;

/**
 * Class Connection
 * @package Box\Model
 * @todo add in method to access last curl info, error and error number for debugging
 */
class Connection extends Model implements ConnectionInterface
{

    protected $responseType = "code";
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $state;
    protected $requestType = "GET";

    protected $response;
    protected $responseClass='Box\Model\Connection\Response';

    /**
     * @var array array of options with the options as the key and the option values as the value
     */
    protected $curlOpts=array();

    // relooking over auth flow, we have to assume app is already authorized externally. rewrite to use tokens for connection
    // may need to store the tokens
    public function connect()
    {

    }

    /**
     * @return resource
     */
    public function initCurl()
    {
        $ch = curl_init();
        $this->initCurlOpts($ch);
        return $ch;
    }

    /**
     * @param $ch
     */
    public function initCurlOpts($ch)
    {
        curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
        return $ch;
    }

    /**
     * @param $ch
     * @return mixed
     */
    public function getCurlData($ch)
    {
        $data = curl_exec($ch);
        return $data;
    }

    public function initAdditionalCurlOpts($ch)
    {
        $opts = $this->getCurlOpts();
        if (0 != count($opts))
        {
            foreach ($opts as $opt=>$optValue)
            {
                // CURLOPT_HTTPHEADER, CURLOPT_QUOTE, CURLOPT_HTTP200ALIASES and CURLOPT_POSTQUOTE require array or object arguments

                switch ($opt)
                {
                    case "CURLOPT_HTTPHEADER":
                    case "CURLOPT_QUOTE":
                    case "CURLOPT_HTTP200ALIASES":
                    case "CURLOPT_POSTQUOTE":
                        // throw exception so it doesn't throw a warning
                        if (!is_array($optValue))
                        {
                            $this->error(
                                array(
                                    'error' => 'curl opt (' . $opt . ') needs to be an array or object',
                                    'error_description' => 'curl opt (' . $opt . ') needs to be an array or object'
                                )
                            );
                        }
                        curl_setopt($ch, constant($opt), $optValue);
                        break;
                    default:
                        curl_setopt($ch, constant($opt), $optValue);
                        break;
                }

            }
        }
        return $ch;
    }

    /**
     * GET
     * @param $uri
     * @return mixed
     */
    public function query($uri)
    {
        $ch = $this->initCurl();
        $ch = $this->initCurlOpts($ch);
        curl_setopt($ch, CURLOPT_URL, $uri);
        $ch = $this->initAdditionalCurlOpts($ch);
        $data = $this->getCurlData($ch);
        curl_close($ch);

        return $data;
    }

    public function delete($uri)
    {
        throw new Exception('stubbed method. please implement');
    }

    public function put($uri, $params = array(), $nameValuePair = false)
    {
        $ch = $this->initCurl();
        $ch = $this->initCurlOpts($ch);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        if ($nameValuePair)
        {
            $params = json_encode($params);
        }

        if (is_array($params))
        {
            $postParams = $this->buildQuery($params);
        }
        else
        {
            $postParams = $params;
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        $ch = $this->initAdditionalCurlOpts($ch);
        $data = $this->getCurlData($ch);
        curl_close($ch);

        return $data;

    }

    /**
     * POST
     * @param              $uri
     * @param array|string $params will convert array to string
     * @param bool         $nameValuePair
     * @return mixed
     */
    public function post($uri, $params = array(), $nameValuePair = false)
    {

        $ch = $this->initCurl();
        $ch = $this->initCurlOpts($ch);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);

        if ($nameValuePair)
        {
            $params = json_encode($params);
        }

        if (is_array($params))
        {
            $postParams = $this->buildQuery($params);
        }
        else
        {
            $postParams = $params;
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        $ch = $this->initAdditionalCurlOpts($ch);
        $data = $this->getCurlData($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @param string $pathToFile
     * @param string $mimeType
     * @param string $filename name of the file/post name
     * @return CURLFile
     */
    public function createCurlFile($pathToFile, $mimeType, $filename)
    {
        $curlFile = new CURLFile($pathToFile,$mimeType, $filename);
        return $curlFile;
    }

    /**
     * @param string $file file/path to file
     * @return mixed
     */
    public function getMimeType($file)
    {
        $fInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fInfo, $file);

        return $mimeType;
    }

    /**
     * @param string     $uri
     * @param string    $file file/path to file
     * @param int $parentId
     * @return array|mixed
     */
    public function postFile($uri, $file, $parentId = 0)
    {
        // @todo allow Content-MD5 header to be set
        //Post 1-n files, each element of $files array assumed to be absolute
        // path to a file.  $files can be array (multiple) or string (one file).
        // Data will be posted in a series of POST vars named $file0, $file1...
        // $fileN

        $pathInfo = pathinfo($file);
        $filename = $file;
        if (array_key_exists('filename', $pathInfo))
        {
            $filename = $pathInfo['filename'] . "." . $pathInfo['extension'];
        }

        $mimeType = $this->getMimeType($file);

        $curlFile = $this->createCurlFile($file, $mimeType, $filename);

        $data=array(
            'file' => $curlFile,
            'parent_id' => $parentId
        );

        $ch = $this->initCurl();
        $ch = $this->initCurlOpts($ch);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $ch = $this->initAdditionalCurlOpts($ch);
        $data = $this->getCurlData($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @param array $curlOpts
     * @return Connection|ConnectionInterface
     */
    public function setCurlOpts($curlOpts = null)
    {
        if (!is_array($curlOpts))
        {
            $curlOpts = array($curlOpts);
        }
        $this->curlOpts = $curlOpts;
        return $this;
    }

    /**
     * @return array
     */
    public function getCurlOpts()
    {
        return $this->curlOpts;
    }

    public function setResponseClass($responseClass = null)
    {
        $this->validateClass($responseClass,'ResponseInterface');
        $this->responseClass = $responseClass;
        return $this;
    }

    public function getResponseClass()
    {
        return $this->responseClass;
    }

    public function setClientId($clientId = null)
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientSecret($clientSecret = null)
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function setRedirectUri($redirectUri = null)
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setRequestType($requestType = null)
    {
        $this->requestType = $requestType;
        return $this;
    }

    public function getRequestType()
    {
        return $this->requestType;
    }

    public function setResponse($response = null)
    {
        $this->response = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponseType($responseType = null)
    {
        $this->responseType = $responseType;
        return $this;
    }

    public function getResponseType()
    {
        return $this->responseType;
    }

    public function setState($state = null)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

}
