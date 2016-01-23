<?php
/**
 * @package     Box
 * @subpackage  Box_Model_Connection
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

namespace Box\Model\Connection\Token;

use Box\Model\ModelInterface;

interface TokenInterface extends ModelInterface
{
    public function getGrantType();

    public function getAccessToken();

    public function setAccessToken($accessToken = null);

    public function getRefreshToken();

    public function setRefreshToken($refreshToken = null);

    public function getExpiresIn();

    public function setExpiresIn($expiresIn = null);

    public function getTokenType();

    public function setTokenType($tokenType = null);

    /**
     * @return array
     */
    public function getRestrictedTo();

    /**
     * @param array $restrictedTo
     *
     * @return TokenInterface
     */
    public function setRestrictedTo($restrictedTo = null);
}
