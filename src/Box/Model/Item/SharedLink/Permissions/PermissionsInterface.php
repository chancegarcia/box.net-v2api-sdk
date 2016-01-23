<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:50 PM
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

namespace Box\Model\Item\SharedLink\Permissions;

use Box\Model\ModelInterface;

interface PermissionsInterface extends ModelInterface
{
    /**
     * @return bool
     */
    public function getCanDownload();

    /**
     * @param bool $canDownload
     *
     * @return PermissionsInterface
     */
    public function setCanDownload($canDownload = null);

    /**
     * @return bool
     */
    public function getCanPreview();

    /**
     * @param bool $canPreview
     *
     * @return PermissionsInterface
     */
    public function setCanPreview($canPreview = null);
}