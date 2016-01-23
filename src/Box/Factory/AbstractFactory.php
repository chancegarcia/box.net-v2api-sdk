<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/30/15
 * Time: 9:43 AM
 * @package     Box
 * @subpackage  Box_Factory
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

namespace Box\Factory;

use Box\Exception\FactoryException;
use Box\Model\ModelInterface;

abstract class AbstractFactory
{
    static public function get($class = null, $options = null)
    {
        if (!is_string($class))
        {
            throw new FactoryException('referenced class must be a string');
        }
        $instance = null;

        if (class_exists($class) && is_subclass_of($class, 'Box\Model\ModelInterface'))
        {
            $instance = new $class($options);
        }
        else
        {
            if (class_exists($class) && !is_subclass_of($class, 'Box\Model\ModelInterface'))
            {
                throw new FactoryException('unable to instantiate with options, class ('
                                           . $class
                                           . ') must be an instance of Box\Model\ModelInterface',
                                           FactoryException::CAN_NOT_INSTANTIATE_WITH_OPTIONS);
            }
            else
            {
                throw new FactoryException('referenced class (' . $class . ') does not exist',
                                           FactoryException::CLASS_DOES_NOT_EXIST);
            }
        }

        return $instance;
    }
}