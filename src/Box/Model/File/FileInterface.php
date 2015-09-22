<?php
/**
 * @package     Box
 * @subpackage  Box_File
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */
/**
 * @todo flush out this interface more. not needed for current project but starting stub for client injection
 */

namespace Box\Model\File;


use Box\Model\ModelInterface;

interface FileInterface extends  ModelInterface
{
    const URI = "https://api.box.com/2.0/files";
    const UPLOAD_URI = "https://upload.box.com/api/2.0/files/content";

    public function getId();
}
