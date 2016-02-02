<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 * connection assumes a valid access token
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

namespace Box\Model\Connection;
use Box\Http\Response\BoxResponse;
use Box\Http\Response\BoxResponseInterface;
use Box\Model\Model;
use Box\Exception\BoxException;
use Box\Model\Connection\Token\TokenInterface;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Response\AuthenticationResponseInterface;
use Box\Model\Connection\Response\AuthenticationResponse;
use \CURLFile;
use Psr\Log\LoggerInterface;

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

    protected $authenticationResponse;
    protected $authenticationResponseClass='Box\Model\Connection\AuthenticationResponse';

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
        // get full response with headers
        // http://stackoverflow.com/questions/9183178/php-curl-retrieving-response-headers-and-body-in-a-single-request
        curl_setopt($ch , CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        curl_setopt($ch , CURLOPT_SSL_VERIFYPEER , false);
        return $ch;
    }

    /**
     * @param $ch
     * @return BoxResponseInterface
     */
    public function getCurlData($ch)
    {
        if ($this->getLogger() instanceof LoggerInterface) {
            $this->getLogger()->debug('before curl_exec curl opts', array(
                __METHOD__ . ":" . __LINE__,
                var_export(curl_getinfo($ch), true),
            ));
        }
        $sResponse = curl_exec($ch);
        if ($this->getLogger() instanceof LoggerInterface) {
            $this->getLogger()->debug('curl_exec response: ' . $sResponse, array(
                __METHOD__ . ":" . __LINE__,
            ));
        }

        // split curl result into header and body
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($sResponse, 0, $header_size);
        $body = substr($sResponse, $header_size);

        $oResponse = new BoxResponse($body, $header);

        return $oResponse;
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
     * @return BoxResponseInterface
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
        throw new BoxException('stubbed method. please implement');
    }

    /**
     * @param $uri
     * @param array|string $params array will be deprecated in the future; json encoded string will become the only valid value
     * @param bool|false $nameValuePair this will be deprecated/fully removed in the future since params as a json encoded
     *                                  string will be the expected value
     *
     * @return BoxResponseInterface
     */
    public function put($uri, $params = array(), $nameValuePair = false)
    {
        $ch = $this->initCurl();
        $ch = $this->initCurlOpts($ch);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        if ($nameValuePair)
        {
            $params = json_encode($params);
            @trigger_error('the `nameValuePair` switch will be deprecated in the future; all values will be json encoded values',
                           E_USER_DEPRECATED);
        }

        if (is_array($params))
        {
            $postParams = $this->buildQuery($params);
            @trigger_error('the `params` value as an array will be deprecated in the future. Please provide a json encoded string',
                           E_USER_DEPRECATED);
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
     *
     * @param              $uri
     * @param array|string $params will convert array to string; array will be deprecated in the future; json
     *                                  encoded string will become the only valid value
     * @param bool|false $nameValuePair this will be deprecated/fully removed in the future since params as a json
     *                                  encoded string will be the expected value
     *
     * @return BoxResponseInterface
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
            @trigger_error('the `nameValuePair` switch will be deprecated in the future; all values will be json encoded values',
                           E_USER_DEPRECATED);
        }

        if (is_array($params))
        {
            $postParams = $this->buildQuery($params);
            @trigger_error('the `params` value as an array will be deprecated in the future. Please provide a json encoded string',
                           E_USER_DEPRECATED);
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
     * @param string $uri
     * @param string $file file/path to file
     * @param int $parentId
     * @return array|BoxResponseInterface
     */
    public function postFile($uri, $file, $parentId = 0)
    {
        // @todo allow Content-MD5 header to be set
        // Post 1-n files, each element of $files array assumed to be absolute
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

    public function setAuthenticationResponseClass($authenticationResponseClass = null)
    {
        $this->validateClass($authenticationResponseClass,'AuthenticationResponseInterface');
        $this->authenticationResponseClass = $authenticationResponseClass;
        return $this;
    }

    public function getAuthenticationResponseClass()
    {
        return $this->authenticationResponseClass;
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

    public function setAuthenticationResponse($authenticationResponse = null)
    {
        $this->authenticationResponse = $authenticationResponse;
        return $this;
    }

    public function getAuthenticationResponse()
    {
        return $this->authenticationResponse;
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
