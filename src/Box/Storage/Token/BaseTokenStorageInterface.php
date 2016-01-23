<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 2:14 PM
 *
 * @package     Box
 * @subpackage  Box_Storage
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
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