<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 2:14 PM
 */

namespace Box\Storage\Token;


use Box\Model\Connection\Token\TokenInterface;

interface BaseTokenStorageInterface
{
    /**
     * add/insert/store token to storage
     *
     * @param \Box\Model\Connection\Token\TokenInterface $token
     *
     * @return mixed
     */
    public function storeToken(TokenInterface $token);

    /**
     * @param \Box\Model\Connection\Token\TokenInterface $token
     * @param mixed $tokenUpdateClause update context such as a where clause
     *
     * @return mixed
     */
    public function updateToken(TokenInterface $token, $tokenUpdateClause = null);

    /**
     * @param mixed $retrievalWhereClause retrieval context such as a where clause
     *
     * @return mixed
     */
    public function retrieveToken($retrievalWhereClause = null);
}