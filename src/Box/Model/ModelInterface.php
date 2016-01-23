<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:36 PM
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

interface ModelInterface extends BaseModelInterface
{

    public function __construct(array $options = null);

    /**
     * class properties as an array
     *
     * @return array
     */
    public function classArray();

    /**
     * same as class array except empty elements are filtered out
     * @return array
     */
    public function toBoxArray();

    /**
     * used to throw exceptions that need to contain error information returned from Box
     *
     * @param $data array containing error and error_description keys
     *
     * @throws \Box\Exception\BoxException
     */
    public function error($data);

    /**
     * @param string $class
     * @param  string $classType
     *
     * @throws \Box\Exception\BoxException
     * @return bool returns true if validation passes. Throws exception if unable to validate or validation doesn't pass
     */
    public function validateClass($class, $classType);

    public function buildQuery($params, $numericPrefix = null);

    public function getNewClass($className = null, $classConstructorOptions = null);
}