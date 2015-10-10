<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 2:55 PM
 */

namespace Box\Model\Service;

use Box\Exception\TokenStorageException;
use Box\Model\BaseModel;
use Box\Exception\BoxException;
use Box\Model\Connection\Connection, Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Token\Token, Box\Model\Connection\Token\TokenInterface;
use Box\Model\ModelInterface;
use Box\Storage\Token\BaseTokenStorageInterface;
use OutOfBoundsException;
use RuntimeException;
use InvalidArgumentException;
use BadMethodCallException;
use stdClass;

class Service extends BaseModel implements ServiceInterface
{
    /**
     * basic connection used in initial authorization to execute token refresh for authorized connection
     * @var Connection|ConnectionInterface
     */
    protected $connection;

    /**
     * separate connection object that contains the token and has set the auth headers {@see ConnectionFactory}
     * @var Connection|ConnectionInterface
     */
    protected $authorizedConnection;

    protected $additionalConnectionHeaders = array();

    /**
     * @var Token|TokenInterface
     */
    protected $token;

    /**
     * @var BaseTokenStorageInterface
     */
    protected $tokenStorage;

    protected $tokenStorageContext;

    protected $clientId;
    protected $clientSecret;
    protected $deviceId = null;
    protected $deviceName = null;

    protected $lastResultOriginal;
    protected $lastResultDecoded;
    protected $lastResultFlat;
    protected $defaultReturnType = 'decoded';
    private $allowedReturnTypes = array(
        'decoded',
        'original',
        'flat',
    );

    /**
     * {@inheritdoc}
     */
    public function getDefaultReturnType()
    {
        return $this->defaultReturnType;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultReturnType($defaultReturnType = 'decoded')
    {
        $this->validateReturnType($defaultReturnType);

        $this->defaultReturnType = $defaultReturnType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastResult($type = 'decoded')
    {
        $this->validateReturnType($type);

        $prop = "lastResult" . ucfirst($type);

        return $this->{$prop};
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizedConnection()
    {
        if (!$this->authorizedConnection instanceof ConnectionInterface)
        {
            throw new RuntimeException("ConnectionInterface not found");
        }

        $headers = $this->getConnectionHeaders();

        $this->authorizedConnection->setCurlOpts(array('CURLOPT_HTTPHEADER' => $headers));

        return $this->authorizedConnection;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthorizedConnection($authorizedConnection = null)
    {
        $this->authorizedConnection = $authorizedConnection;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
        if (!$this->connection instanceof ConnectionInterface)
        {
            throw new \RuntimeException("ConnectionInterface not found");
        }

        return $this->connection;
    }

    /**
     * @param Connection|ConnectionInterface $connection
     *
     * @return ServiceInterface|Service
     */
    public function setConnection($connection = null)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdditionalConnectionHeaders()
    {
        return $this->additionalConnectionHeaders;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdditionalConnectionHeaders($additionalConnectionHeaders = null)
    {
        $this->additionalConnectionHeaders = $additionalConnectionHeaders;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        if (!$this->token instanceof TokenInterface)
        {
            throw new \RuntimeException('TokenInterface not found');
        }

        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function setToken($token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * {@inheritdoc}
     */
    public function setClientId($clientId = null)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * {@inheritdoc}
     */
    public function setClientSecret($clientSecret = null)
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     *{@inheritdoc}
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeviceId($deviceId = null)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeviceName()
    {
        return $this->deviceName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeviceName($deviceName = null)
    {
        $this->deviceName = $deviceName;

        return $this;
    }

    /**
     *{@inheritdoc}
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenStorage(BaseTokenStorageInterface $tokenStorage = null)
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenStorageContext()
    {
        return $this->tokenStorageContext;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenStorageContext($tokenStorageContext = null)
    {
        $this->tokenStorageContext = $tokenStorageContext;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Box\Exception\BoxException
     */
    public function error($data, $message = null)
    {
        $error = $data['error'];
        if (null === $message || !is_string($message))
        {
            $message = $error;
        }

        $exception = new BoxException($message);
        $exception->setError($error);
        $exception->setErrorDescription($data['error_description']);
        throw $exception;
    }

    /**
     * {@inheritdoc}
     */
    final public function putIntoBox($uri = null, $params = array(), $returnType = 'decoded')
    {
        $this->validateReturnType($returnType);

        if (false === is_string($uri))
        {
            throw new BadMethodCallException("please provide a URI");
        }

        if (!is_string($params))
        {
            $params = json_encode($params);
        }

        $json = $this->getAuthorizedConnection()->put($uri, $params);

        return $this->getFinalConnectionResult($json, $returnType);
    }

    /**
     * {@inheritdoc}
     * @throws BadMethodCallException
     */
    final public function queryBox($uri = null, $returnType = 'decoded')
    {
        $this->validateReturnType($returnType);

        if (false === is_string($uri))
        {
            throw new BadMethodCallException("please provide a URI");
        }

        $connection = $this->getAuthorizedConnection();

        $json = $connection->query($uri);

        return $this->getFinalConnectionResult($json, $returnType);
    }

    /**
     * {@inheritdoc}
     */
    final public function sendUpdateToBox($uri = null, $params = array(), $type = 'original', ModelInterface $class = null)
    {
        $this->validateReturnType($type);
        try
        {
            $boxData = $this->putIntoBox($uri, $params, $type);
        }
        catch (BoxException $be)
        {
            $currentToken = clone $this->getToken();
            try
            {
                // set previous token information for token storage to use if needed
                $this->getTokenStorage()->setPreviousToken($currentToken);
                $refreshedToken = $this->refreshToken();
                $tokenStorageContext = $this->getTokenStorageContext();
                $this->getTokenStorage()->updateToken($refreshedToken, $tokenStorageContext);
                $this->setToken($refreshedToken);
                // retry query
                $boxData = $this->putIntoBox($uri, $params, $type);
            }
            catch (BoxException $refreshException)
            {
                $this->getTokenStorage()->setPreviousToken(null);
                $refreshMessage =
                    "encountered exception during refresh token attempt" . $refreshException->getMessage();
                $finalException = new BoxException($refreshMessage, $refreshException->getCode(), $be);
                $finalException->addContext($refreshException);
                throw $finalException;
            }
            catch (TokenStorageException $tse)
            {
                // add some context if none already given and rethrow
                if (!$tse->getPreviousToken() instanceof TokenInterface)
                {
                    $tse->setPreviousToken($currentToken);
                }

                throw $tse;
            }
        }

        $errorCheck = $this->getLastResult('flat');

        /**
         * error decoding json data
         */
        if (null === $errorCheck)
        {
            $errorData['error'] = "unable to decode json data";
            $errorData['error_description'] = 'try refreshing the token';
            $this->error($errorData);
        }

        $returnData = null;
        if ($class instanceof ModelInterface)
        {
            $returnData = $class->mapBoxToClass($this->getLastResult('decoded'));
        }
        else
        {
            $returnData = $boxData;
        }

        return $returnData;
    }

    /**
     * this will attempt to retrieve from box and refresh the token if necessary then update the token storage
     *
     * {@inheritdoc}
     * @throws \Box\Exception\BoxException|\Box\Exception\TokenStorageException for TokenStorageException, we will set
     *     previous token information here if it isn't set already from the TokenStorageException. then rethrow; Token
     *     storage is expected to set all other context values for information.
     */
    final public function getFromBox($uri = null, $type = 'original', ModelInterface $class = null)
    {
        $this->validateReturnType($type);

        try
        {
            $boxData = $this->queryBox($uri, $type);
        }
        catch (BoxException $be)
        {
            $currentToken = clone $this->getToken();
            try
            {
                // set previous token information for token storage to use if needed
                $this->getTokenStorage()->setPreviousToken($currentToken);
                $refreshedToken = $this->refreshToken();
                $tokenStorageContext = $this->getTokenStorageContext();
                $this->getTokenStorage()->updateToken($refreshedToken, $tokenStorageContext);
                $this->setToken($refreshedToken);
                // retry query
                $boxData = $this->queryBox($uri, $type);
            }
            catch (BoxException $refreshException)
            {
                $this->getTokenStorage()->setPreviousToken(null);
                $refreshMessage =
                    "encountered exception during refresh token attempt" . $refreshException->getMessage();
                $finalException = new BoxException($refreshMessage, $refreshException->getCode(), $be);
                $finalException->addContext($refreshException);
                throw $finalException;
            }
            catch (TokenStorageException $tse)
            {
                // add some context if none already given and rethrow
                if (!$tse->getPreviousToken() instanceof TokenInterface)
                {
                    $tse->setPreviousToken($currentToken);
                }

                throw $tse;
            }
        }

        $errorCheck = $this->getLastResult('flat');

        /**
         * error decoding json data
         */
        if (null === $errorCheck)
        {
            $errorData['error'] = "unable to decode json data";
            $errorData['error_description'] = 'try refreshing the token';
            $this->error($errorData);
        }

        $returnData = null;
        if ($class instanceof ModelInterface)
        {
            $returnData = $class->mapBoxToClass($this->getLastResult('decoded'));
        }
        else
        {
            $returnData = $boxData;
        }

        return $returnData;
    }

    /**
     * {@inheritdoc}
     * @throws \Box\Exception\BoxException
     */
    public function getConnectionHeaders()
    {
        $headers = array($this->getAuthorizationHeader());

        $additionalConnectionHeaders = $this->getAdditionalConnectionHeaders();

        if (null !== $additionalConnectionHeaders && !is_array($additionalConnectionHeaders))
        {
            throw new BoxException('additional headers must be in array format', BoxException::INVALID_INPUT);
        }

        if (is_array($additionalConnectionHeaders))
        {
            $headers = array_merge($headers, $additionalConnectionHeaders);
        }

        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationHeader()
    {
        $token = $this->getToken();

        $header = "Authorization: Bearer " . $token->getAccessToken();

        return $header;
    }

    /**
     * this does not update the token storage with the refreshed token; that action is handled by user or a wrapped
     * method
     * {@inheritdoc}
     * @throws \Box\Exception\BoxException
     */
    public function refreshToken()
    {
        $token = $this->getToken();

        $params['refresh_token'] = $token->getRefreshToken();
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();
        $params['grant_type'] = 'refresh_token';

        $deviceId = $this->getDeviceId();
        if (null !== $deviceId)
        {
            $params['device_id'] = $deviceId;
        }

        $deviceName = $this->getDeviceName();
        if (null !== $deviceName)
        {
            $params['device_name'] = $deviceName;
        }

        $connection = $this->getConnection();

        $json = $connection->post(self::TOKEN_URI, $params);
        // need to handle stdclass vs forced array?
        $this->lastResultOriginal = $json;
        $this->lastResultDecoded = json_decode($json);
        $this->lastResultFlat = json_decode($json, true);

        $data = $this->getLastResult($this->getDefaultReturnType());
        $errorCheck = $this->getLastResult('flat');

        if (null === $errorCheck)
        {
            $errorCheck['error'] = "sdk_json_decode";
            $errorCheck['error_description'] = "unable to decode or recursion level too deep";
            $this->error($errorCheck);
        }
        else
        {
            if (array_key_exists('error', $errorCheck))
            {
                $this->error($errorCheck);
            }
        }

        $this->setTokenData($token, $data);

        $this->setToken($token);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenData(TokenInterface $token, $data)
    {
        if (is_array($data))
        {
            $token->setAccessToken($data['access_token']);
            $token->setExpiresIn($data['expires_in']);
            $token->setTokenType($data['token_type']);
            $token->setRefreshToken($data['refresh_token']);
        }
        else
        {
            if ($data instanceof stdClass)
            {
                $token->setAccessToken($data->access_token);
                $token->setRefreshToken($data->refresh_token);
                $token->setExpiresIn($data->expires_in);
                $token->setTokenType($data->token_type);
            }
            else
            {
                throw new RuntimeException('unexpected token data. unable to set. given ('
                                           . var_export($data, true)
                                           . ')');
            }
        }

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function destroyToken(TokenInterface $token, $returnType = 'decoded')
    {
        $this->validateReturnType($returnType);
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();
        // The access_token or refresh_token to be destroyed. Only one is required, though both will be destroyed.
        $params['token'] = $token->getAccessToken();

        $connection = $this->getConnection();

        $json = $connection->post(self::REVOKE_URI, $params);
        // @todo add error handling for null data
        $this->lastResultOriginal = $json;
        $this->lastResultDecoded = json_decode($json);
        $this->lastResultFlat = json_decode($json, true);

        $data = $this->getLastResult($returnType);

        // remove token from storage
        $this->getTokenStorage()->removeToken($token, $this->getTokenStorageContext());

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function validateReturnType($type = null)
    {
        if (!is_string($type))
        {
            throw new InvalidArgumentException('string type expected');
        }

        if (!in_array($type, $this->allowedReturnTypes))
        {
            $validTypes = explode(",", $this->allowedReturnTypes);
            throw new OutOfBoundsException($type . " is not a valid result type. valid types: " . $validTypes);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws \Box\Exception\BoxException
     * @throws BadMethodCallException
     */
    public function getFinalConnectionResult($json = null, $returnType = 'decoded', $errorData = array())
    {
        if (!is_string($json))
        {
            throw new BadMethodCallException('expecting json string. received: ' . gettype($json));
        }

        $this->validateReturnType($returnType);

        $this->lastResultOriginal = $json;
        $this->lastResultDecoded = json_decode($json);
        $this->lastResultFlat = json_decode($json, true);

        $data = $this->getLastResult($returnType);

        if (null === $this->lastResultFlat)
        {
            $errorData = array();
            $errorData['error'] = "sdk_json_decode";
            $errorData['error_description'] = "unable to decode or recursion level too deep";
            $this->error($errorData);
        }
        else
        {
            if (array_key_exists('error', $this->lastResultFlat))
            {
                $this->error($this->lastResultFlat);
            }
            else
            {
                if (array_key_exists('type', $this->lastResultFlat) && 'error' == $this->lastResultFlat['type'])
                {
                    $errorData['error'] = "sdk_unknown";
                    $ditto = $errorData;
                    $errorData['error_description'] = $ditto;
                    $this->error($errorData);
                }
            }
        }

        return $data;
    }
}