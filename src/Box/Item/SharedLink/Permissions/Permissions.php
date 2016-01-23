<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:51 PM
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

namespace Box\Item\SharedLink\Permissions;

use Box\Model\Item\SharedLink\Permissions\PermissionsInterface;
use Box\Model\Model;

class Permissions extends Model implements PermissionsInterface
{
    protected $canDownload;
    protected $canPreview;

    /**
     * {@inheritdoc}
     */
    public function getCanDownload()
    {
        return $this->canDownload;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanDownload($canDownload = null)
    {
        $this->canDownload = $canDownload;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCanPreview()
    {
        return $this->canPreview;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanPreview($canPreview = null)
    {
        $this->canPreview = $canPreview;

        return $this;
    }
}