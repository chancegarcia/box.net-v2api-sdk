<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/30/15
 * Time: 10:47 AM
 * @package     Box
 * @subpackage  Box_Exception
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

namespace Box\Exception;

class FactoryException extends BoxException
{
    const CLASS_DOES_NOT_EXIST = 1;
    const CAN_NOT_INSTANTIATE_WITH_OPTIONS = 2;
}