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
    protected $token;

    /**
     * @return mixed
     */
    public function retrieveToken($retrievalWhereClause = null)
    {
        return $this->token;
    }

    /**
     * @param TokenInterface $token
     *
     * @return BaseTokenStorageInterface
     */
    public function storeToken(TokenInterface $token = null)
    {
        $this->token = $token;

        return $this;
    }


    /**
     * @param \Box\Model\Connection\Token\TokenInterface $token
     * @param mixed $tokenUpdateClause update context such as a where clause
     *
     * @return mixed
     */
    public function updateToken(TokenInterface $token, $tokenUpdateClause = null)
    {
        $this->token = $token;
    }
}