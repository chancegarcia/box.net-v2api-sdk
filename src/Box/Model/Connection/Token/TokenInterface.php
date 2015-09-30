<?php
/**
 * @package     Box
 * @subpackage  Box_Model_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
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
