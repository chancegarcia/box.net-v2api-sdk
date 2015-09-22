<?php
/**
 * @package     Box
 * @subpackage  Box_Folder
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Folder;

use Box\Model\ModelInterface;

interface FolderInterface extends ModelInterface
{
    const URI =  'https://api.box.com/2.0/folders';
    const SHARED_ITEM_URI = "https://api.box.com/2.0/shared_items";

    public function getId();
    public function getItems();
    public function classArray($syncState = "synced");
}
