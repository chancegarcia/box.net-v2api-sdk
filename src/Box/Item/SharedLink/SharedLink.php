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
 *    The MIT License (MIT)
 *
 * Copyright (c) 2013-2016 Chance Garcia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
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