<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 2:58 PM
 */

namespace Box\Model\Service;


use Box\Model\BaseModelInterface;
use Box\Model\Connection\Connection;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Token\Token;
use Box\Model\Connection\Token\TokenInterface;
use Box\Model\Model;
use Box\Model\ModelInterface;
use Box\Storage\Token\BaseTokenStorageInterface;

/**
 * basic service interface expects a valid authorized token;
 * it has the ability to refresh or revoke but not do the initial authorization.
 * see the authorize service for that ability
 *
 *
 *
 * Interface ServiceInterface
 * @package Box\Model\Service
 */
interface ServiceInterface extends BaseModelInterface
{
    const TOKEN_URI = "https://www.box.com/api/oauth2/token";
    const REVOKE_URI = "https://www.box.com/api/oauth2/revoke";

    /**
     * @return Connection|ConnectionInterface
     */
    public function getConnection();

    /**
     * @param Connection|ConnectionInterface $connection
     *
     * @return ServiceInterface|Service
     */
    public function setConnection($connection = null);

    /**
     * @return Connection|ConnectionInterface
     */
    public function getAuthorizedConnection();

    /**
     * @param Connection|ConnectionInterface $authorizedConnection
     *
     * @return ServiceInterface|Service
     */
    public function setAuthorizedConnection($authorizedConnection = null);

    /**
     * @return array
     */
    public function getAdditionalConnectionHeaders();

    /**
     * @param array $additionalConnectionHeaders
     *
     * @return ServiceInterface|Service
     */
    public function setAdditionalConnectionHeaders($additionalConnectionHeaders = null);

    /**
     * @return Token|TokenInterface
     */
    public function getToken();

    /**
     * @param Token|TokenInterface $token
     *
     * @return ServiceInterface|Service
     */
    public function setToken($token = null);

    /**
     * @return mixed
     */
    public function getClientId();

    /**
     * @param mixed $clientId
     *
     * @return ServiceInterface|Service
     */
    public function setClientId($clientId = null);

    /**
     * @param mixed $clientSecret
     *
     * @return ServiceInterface|Service
     */
    public function setClientSecret($clientSecret = null);

    /**
     * @return mixed
     */
    public function getClientSecret();

    /**
     * @return mixed
     */
    public function getDeviceId();

    /**
     * @param mixed $deviceId
     *
     * @return ServiceInterface|Service
     */
    public function setDeviceId($deviceId = null);

    /**
     * @return mixed
     */
    public function getDeviceName();

    /**
     * @param mixed $deviceName
     *
     * @return ServiceInterface|Service
     */
    public function setDeviceName($deviceName = null);

    /**
     * used to throw exceptions that need to contain error information returned from Box
     *
     * @param $data array containing error and error_description keys
     * @param $message string exception message
     *
     */
    public function error($data, $message = null);

    /**
     * @return string
     */
    public function getAuthorizationHeader();

    /**
     * @return array
     */
    public function getConnectionHeaders();

    /**
     * @param string $uri
     *
     * @return ServiceInterface|Service
     */
    public function queryBox($uri = null);

    /**
     * @param null $uri
     * @param ModelInterface $class class to map the box data to; if none provided, original json return will be returned
     *
     * @return ModelInterface|Model
     */
    public function getFromBox($uri = null, ModelInterface $class = null);

    /**
     * refreshes the token and returns new token; it is up to the application to persist the new token data
     *
     * @return Token|TokenInterface
     */
    public function refreshToken();

    /**
     * @param $token TokenInterface|Token
     * @param $data
     *
     * @return TokenInterface|Token
     */
    public function setTokenData(Token $token, $data);

    /**
     * @param $token TokenInterface|Token
     *
     * @return mixed
     */
    public function destroyToken(Token $token);

    /**
     * @return BaseTokenStorageInterface
     */
    public function getTokenStorage();

    /**
     * @param BaseTokenStorageInterface|null $tokenStorage
     *
     * @return ServiceInterface
     */
    public function setTokenStorage(BaseTokenStorageInterface $tokenStorage = null);
}