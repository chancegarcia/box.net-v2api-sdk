<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 5:25 PM
 * @package     Box
 * @subpackage  Box_Model
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

namespace Box\Model;

interface BaseModelInterface
{
    /**
     * @param $str
     *
     * @return mixed
     */
    public function toClassVar($str);

    public function toBoxVar($str);

    /**
     * this will bomb out if any properties are private
     * @todo try using setter if found?
     *
     * @param $aData
     *
     * @return $this
     */
    public function mapBoxToClass($aData);

    /**
     * validate integer value even if it is a string value, unlike is_int()
     *
     * @param mixed $number
     *
     * @return bool
     */
    public function isInt($number = null);

    /**
     * recursively remove empty elements from an array (trim is applied to string values)
     *
     * @param array $haystack
     *
     * @return array
     */
    public function removeEmpty(array $haystack = array());
}