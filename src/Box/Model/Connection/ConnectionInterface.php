<?php
/**
 * @package     Box
 * @subpackage  Box_Connection
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

namespace Box\Model\Connection;

use Box\Model\Connection\Token\TokenInterface;
use Box\Model\ModelInterface;

interface ConnectionInterface extends ModelInterface
{
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
