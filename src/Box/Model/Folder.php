<?php
/**
 * @package     Box
 * @subpackage  Box_Folder
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Folder;

use Box\Model;
class Folder
    extends Model implements FolderInterface
{
    protected $type = "folder";
    protected $id;
    protected $sequenceId;
    protected $etag;
    protected $name;
    protected $createdAt;
    protected $modifiedAt;
    protected $description;
    protected $size;
    protected $pathCollection;
    protected $createdBy;
    protected $modifiedBy;
    protected $ownedBy;
    protected $sharedLink;
    protected $folderUploadEmail;
    protected $parent;
    protected $itemStatus;
    protected $itemCollection;
    protected $syncState;
    protected $hasCollaborations;

    public function getId()
    {
        // TODO: Implement getId() method.
    }
}
