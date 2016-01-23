<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 1/20/16
 * Time: 9:14 PM
 * @package     Box
 * @subpackage  Box_Logger
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

namespace Box\Logger;

use Psr\Log\LoggerInterface;

interface LoggerAwareInterface extends \Psr\Log\LoggerAwareInterface
{
    /**
     * @return LoggerInterface
     */
    public function getLogger();
}