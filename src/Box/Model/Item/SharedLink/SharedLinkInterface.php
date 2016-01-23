<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:47 PM
 *
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

namespace Box\Model\Item\SharedLink;

use Box\Model\ModelInterface;
use Box\Model\Item\SharedLink\Permissions\PermissionsInterface;

interface SharedLinkInterface extends ModelInterface
{
    /**
     * @return mixed
     */
    public function getEffectiveAccess();

    /**
     * @return mixed
     */
    public function getAccess();

    /**
     * @param mixed $access
     *
     * @return SharedLinkInterface
     */
    public function setAccess($access = null);

    /**
     * @return mixed
     */
    public function getUnsharedAt();

    /**
     * @param mixed $unsharedAt
     *
     * @return SharedLinkInterface
     */
    public function setUnsharedAt($unsharedAt = null);

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @param mixed $password
     *
     * @return SharedLinkInterface
     */
    public function setPassword($password = null);

    /**
     * @return null|PermissionsInterface
     */
    public function getPermissions();

    /**
     * @param PermissionsInterface $permissions
     *
     * @return SharedLinkInterface
     */
    public function setPermissions(PermissionsInterface $permissions = null);
}