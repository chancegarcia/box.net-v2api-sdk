<?php
/**
 * @package     Box
 * @subpackage  Box_Model_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Connection\Token;

interface TokenInterface
{
    public function getGrantType();
    public function getAccessToken();
    public function setAccessToken($accessToken=null);
    public function setRefreshToken($refreshToken=null);
    public function setExpiresIn($expiresIn=null);
    public function setTokenType($tokenType=null);
    public function getRefreshToken();
}
