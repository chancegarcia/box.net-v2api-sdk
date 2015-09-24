<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/24/15
 * Time: 4:52 PM
 */

namespace Box\Exception;


use Box\Model\Connection\Token\TokenInterface;
use Box\Storage\Token\BaseTokenStorageInterface;

class TokenStorageException extends \Exception
{
    /**
     * @var TokenInterface
     */
    protected $token;

    /**
     * @var TokenInterface
     */
    protected $previousToken;

    /**
     * @var BaseTokenStorageInterface
     */
    protected $tokenStorage;
    protected $tokenStorageContext;
    protected $callingClass;

    /**
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param TokenInterface $token
     *
     * @return TokenStorageException
     */
    public function setToken(TokenInterface $token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return TokenInterface
     */
    public function getPreviousToken()
    {
        return $this->previousToken;
    }

    /**
     * @param TokenInterface $previousToken
     *
     * @return TokenStorageException
     */
    public function setPreviousToken(TokenInterface $previousToken = null)
    {
        $this->previousToken = $previousToken;

        return $this;
    }

    /**
     * @return BaseTokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @param BaseTokenStorageInterface $tokenStorage
     *
     * @return TokenStorageException
     */
    public function setTokenStorage($tokenStorage = null)
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTokenStorageContext()
    {
        return $this->tokenStorageContext;
    }

    /**
     * @param mixed $tokenStorageContext
     *
     * @return TokenStorageException
     */
    public function setTokenStorageContext($tokenStorageContext = null)
    {
        $this->tokenStorageContext = $tokenStorageContext;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallingClass()
    {
        return $this->callingClass;
    }

    /**
     * @param mixed $callingClass
     *
     * @return TokenStorageException
     */
    public function setCallingClass($callingClass = null)
    {
        $this->callingClass = $callingClass;

        return $this;
    }
}