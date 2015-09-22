<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 2:55 PM
 */

namespace Box\Model\Service;

use Box\Model\BaseModel;
use Box\Exception\BoxException;
use Box\Model\Connection\Connection, Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Token\Token, Box\Model\Connection\Token\TokenInterface;
use Box\Model\ModelInterface;
use Box\Storage\Token\BaseTokenStorageInterface;

class Service extends BaseModel implements ServiceInterface
{
    /**
     * basic connection used in initial authorization to execute token refresh for authorized connection
     * @var Connection|ConnectionInterface
     */
    protected $connection;

    /**
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

    protected $clientId;
    protected $clientSecret;
    protected $deviceId = null;
    protected $deviceName = null;

    /**
     * {@inheritdoc}
     */
    public function getAuthorizedConnection()
    {
        if (!$this->authorizedConnection instanceof ConnectionInterface)
        {
            throw new \RuntimeException("ConnectionInterface not found");
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
     * @throws \BadMethodCallException
     */
    public function queryBox($uri = null)
    {
        if (false === is_string($uri))
        {
            throw new \BadMethodCallException("please provide a URI");
        }

        $connection = $this->getAuthorizedConnection();

        $json = $connection->query($uri);

        $data = json_decode($json, true);

        if (null === $data)
        {
            $data['error'] = "sdk_json_decode";
            $data['error_description'] = "unable to decode or recursion level too deep";
            $this->error($data);

            return $data;
        }
        else
        {
            if (array_key_exists('error', $data))
            {
                $this->error($data);

                return $data;
            }
            else
            {
                if (array_key_exists('type', $data) && 'error' == $data['type'])
                {
                    $data['error'] = "sdk_unknown";
                    $ditto = $data;
                    $data['error_description'] = $ditto;
                    $this->error($data);

                    return $data;
                }
            }
        }

        return $data;
    }

    /**
     * this will attempt to retrieve from box and refresh the token if necessary then update the token storage
     *
     * {@inheritdoc}
     * @throws \Box\Exception\BoxException
     */
    public function getFromBox($uri = null, ModelInterface $class = null)
    {
        try
        {
            $boxData = $this->queryBox($uri);
        }
        catch (BoxException $be)
        {
            try
            {
                $refreshedToken = $this->refreshToken();
                $this->getTokenStorage()->updateToken($refreshedToken);
                $this->setToken($refreshedToken);
            }
            catch (BoxException $refreshException)
            {
                $refreshMessage = "encountered exception during refresh token attempt" . $refreshException->getMessage();
                $finalException = new BoxException($refreshMessage, $refreshException->getCode(), $be);
                $finalException->addContext($refreshException);
                throw $finalException;
            }
        }

        $jsonData = json_decode($boxData, true);
        /**
         * API docs says error is thrown if folder does not exist or no access.
         * no example of error to parse by. Have to assume success until can modify
         */

        /**
         * error decoding json data
         */
        if (null === $jsonData)
        {
            $boxData['error'] = "unable to decode json data";
            $boxData['error_description'] = 'try refreshing the token';
            $this->error($boxData);
        }

        $returnData = null;
        if ($class instanceof ModelInterface)
        {
            $returnData = $class->mapBoxToClass($jsonData);
        }
        else
        {
            $returnData = $jsonData;
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
     * this does not update the token storage with the refreshed token; that action is handled by user or a wrapped method
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
        $data = json_decode($json, true);

        if (null === $data)
        {
            $data['error'] = "sdk_json_decode";
            $data['error_description'] = "unable to decode or recursion level too deep";
            $this->error($data);
        }
        else
        {
            if (array_key_exists('error', $data))
            {
                $this->error($data);
            }
        }

        $this->setTokenData($token, $data);

        $this->setToken($token);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenData(Token $token, $data)
    {
        $token->setAccessToken($data['access_token']);
        $token->setExpiresIn($data['expires_in']);
        $token->setTokenType($data['token_type']);
        $token->setRefreshToken($data['refresh_token']);

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function destroyToken(Token $token)
    {
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();
        // The access_token or refresh_token to be destroyed. Only one is required, though both will be destroyed.
        $params['token'] = $token->getAccessToken();

        $connection = $this->getConnection();

        $json = $connection->post(self::REVOKE_URI, $params);
        // @todo add error handling for null data
        // @todo remove token from storage
        $data = json_decode($json, true);

        return $data;
    }
}