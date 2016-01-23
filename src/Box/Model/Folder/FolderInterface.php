<?php
/**
 * @package     Box
 * @subpackage  Box_Folder
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

namespace Box\Model\Folder;

use Box\Model\ModelInterface;

interface FolderInterface extends ModelInterface
{
    const URI = 'https://api.box.com/2.0/folders';
    const SHARED_ITEM_URI = "https://api.box.com/2.0/shared_items";

    public function getId();

    public function getItems();

    public function classArray($syncState = "synced");
}
