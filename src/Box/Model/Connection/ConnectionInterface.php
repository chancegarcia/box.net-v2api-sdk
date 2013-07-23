<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Connection;

use Box\Model\Connection\Token\TokenInterface;

interface ConnectionInterface
{

    public function connect();
    public function query($uri);
    public function post($uri,array $params = array());
}
