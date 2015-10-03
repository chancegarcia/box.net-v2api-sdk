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
     * @return bool return value is success of storage
     */
    public function storeToken(TokenInterface $token);

    /**
     * @param \Box\Model\Connection\Token\TokenInterface $token
     * @param mixed $tokenUpdateClause update context such as a where clause
     *
     * @return bool return value is success of storage
     */
    public function updateToken(TokenInterface $token, $tokenUpdateClause = null);

    /**
     * @param mixed $retrievalWhereClause retrieval context such as a where clause
     *
     * @return TokenInterface
     */
    public function retrieveToken($retrievalWhereClause = null);

    /**
     * @return TokenInterface
     */
    public function getPreviousToken();

    /**
     * store previous token for usage
     *
     * @param TokenInterface|null $previousToken
     *
     * @return BaseTokenStorageInterface
     */
    public function setPreviousToken(TokenInterface $previousToken = null);

    /**
     * remove token from storage
     *
     * @param \Box\Model\Connection\Token\TokenInterface $token
     * @param null $tokenContext
     *
     */
    public function removeToken(TokenInterface $token, $tokenContext = null);
}