<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:48 PM
 * @package     Box
 * @subpackage  Box_Item
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

namespace Box\Item\SharedLink;

use Box\Model\Item\SharedLink\Permissions\PermissionsInterface;
use Box\Model\Item\SharedLink\SharedLinkInterface;
use Box\Model\Model;

class SharedLink extends Model implements SharedLinkInterface
{
    protected $access;
    protected $unsharedAt;
    protected $password;
    protected $permissions;
    protected $effectiveAccess;

    /**
     * {@inheritdoc}
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccess($access = null)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnsharedAt()
    {
        return $this->unsharedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnsharedAt($unsharedAt = null)
    {
        $this->unsharedAt = $unsharedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function setPermissions(PermissionsInterface $permissions = null)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEffectiveAccess()
    {
        return $this->effectiveAccess;
    }
}