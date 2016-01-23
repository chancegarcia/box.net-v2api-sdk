<?php
/**
 * @package     Box
 * @subpackage  Box_File
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
/**
 * @todo flush out this interface more. not needed for current project but starting stub for client injection
 */

namespace Box\Model\File;


use Box\Model\Item\SharedLink\SharedLinkInterface;
use Box\Model\ModelInterface;

interface FileInterface extends  ModelInterface
{
    const URI = "https://api.box.com/2.0/files";
    const UPLOAD_URI = "https://upload.box.com/api/2.0/files/content";

    public function getId();

    /**
     * @return mixed|SharedLinkInterface
     */
    public function getSharedLink();

    public function setSharedLink($sharedLink = null);
}
