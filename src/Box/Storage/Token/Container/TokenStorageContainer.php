<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 4:52 PM
 */

namespace Box\Storage\Token\Container;

use Box\Model\Connection\Token\TokenInterface;
use Box\Storage\Token\BaseTokenStorageInterface;

class TokenStorageContainer implements BaseTokenStorageInterface
{
    /**
     * @var TokenInterface|null
     */
    protected $token;
    /**
     * @var TokenInterface|null
     */
    protected $previousToken;

    /**
     * {@inheritdoc}
     */
    public function getPreviousToken()
    {
        return $this->previousToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setPreviousToken(TokenInterface $previousToken = null)
    {
        $this->previousToken = $previousToken;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveToken($retrievalUpdateClause = null)
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function storeToken(TokenInterface $token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function updateToken(TokenInterface $token, $tokenUpdateClause = null)
    {
        $this->token = $token;
    }

    /**
     * remove token from storage
     *
     * @param \Box\Model\Connection\Token\TokenInterface $token
     * @param null $tokenContext
     *
     */
    public function removeToken(TokenInterface $token, $tokenContext = null)
    {
        $this->token = null;
    }
}