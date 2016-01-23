<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:32 PM
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

namespace Box\Model\Service\File;

use Box\Model\File\FileInterface;
use Box\Model\Item\SharedLink\SharedLinkInterface;
use Box\Model\Service\ServiceInterface;

interface FileServiceInterface extends ServiceInterface
{
    /**
     * @param FileInterface $file
     * @param SharedLinkInterface $sharedLink shared link object used to set box permissions
     *
     * @return FileInterface
     */
    public function createSharedLink(FileInterface $file = null, SharedLinkInterface $sharedLink = null);

    /**
     * @return FileInterface
     */
    public function createNewFile();
}