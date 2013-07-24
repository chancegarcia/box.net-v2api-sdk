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
    protected $_type = "folder";
    protected $_id;
    protected $_sequenceId;
    protected $_etag;
    protected $_name;
    protected $_createdAt;
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
