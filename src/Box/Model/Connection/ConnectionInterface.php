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
    public function __construct($options = null);
    public function connect();
    public function query($uri);
    public function post($uri, $params = array());
    public function initAdditionalCurlOpts($ch);
    public function setCurlOpts($curlOpts = null);
    public function getCurlOpts();
    public function initCurl();
    public function initCurlOpts($ch);
    public function getCurlData($ch);
    public function put($uri, $params = array());
}
