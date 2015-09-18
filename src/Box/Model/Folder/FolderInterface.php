<?php
/**
 * @package     Box
 * @subpackage  Box_Folder
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Folder;

interface FolderInterface
{
    public function __construct($options = null);
    public function getId();
    public function mapBoxToClass($aData);
    public function getItems();
    public function classArray($syncState = "synced");
}
