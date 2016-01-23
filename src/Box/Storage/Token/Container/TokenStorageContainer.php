<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 4:52 PM
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