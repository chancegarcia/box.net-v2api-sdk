<?php
/**
 * @package     Box
 * @subpackage  Box_File
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\File;

use Box\Exception\BoxException;
use Box\Model\Model;
use Box\Model\File\FileInterface;

class File extends Model implements FileInterface
{
    protected $id;
    protected $type;
    protected $sequenceId;
    protected $etag;
    protected $sha1;
    protected $name;
    protected $description;
    protected $size;
    protected $pathCollection;
    protected $createdAt;
    protected $modifiedAt;
    protected $trashedAt;
    protected $purgedAt;
    protected $contentCreatedAt;
    protected $contentModifiedAt;
    protected $createdBy;
    protected $modifiedBy;
    protected $ownedBy;
    protected $sharedLink;
    protected $parent;
    protected $itemStatus;

    // the following will not appear in default file requests and must be explicitly asked for using the fields parameter.
    protected $versionNumber;
    protected $commentCount;
    protected $permissions;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id = null)
    {
        if (!is_numeric($id))
        {
            $id = null;
        }

        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $commentCount
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setCommentCount($commentCount = null)
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * @param mixed $contentCreatedAt
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setContentCreatedAt($contentCreatedAt = null)
    {
        $this->contentCreatedAt = $contentCreatedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentCreatedAt()
    {
        return $this->contentCreatedAt;
    }

    /**
     * @param mixed $contentModifiedAt
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setContentModifiedAt($contentModifiedAt = null)
    {
        $this->contentModifiedAt = $contentModifiedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentModifiedAt()
    {
        return $this->contentModifiedAt;
    }

    /**
     * @param mixed $createdAt
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdBy
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setCreatedBy($createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $description
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $etag
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setEtag($etag = null)
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @param mixed $itemStatus
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setItemStatus($itemStatus = null)
    {
        $this->itemStatus = $itemStatus;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemStatus()
    {
        return $this->itemStatus;
    }

    /**
     * @param mixed $modifiedAt
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setModifiedAt($modifiedAt = null)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param mixed $modifiedBy
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setModifiedBy($modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @param mixed $name
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $ownedBy
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setOwnedBy($ownedBy = null)
    {
        $this->ownedBy = $ownedBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwnedBy()
    {
        return $this->ownedBy;
    }

    /**
     * @param mixed $parent
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $pathCollection
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setPathCollection($pathCollection = null)
    {
        $this->pathCollection = $pathCollection;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPathCollection()
    {
        return $this->pathCollection;
    }

    /**
     * @param mixed $permissions
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setPermissions($permissions = null)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param mixed $purgedAt
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setPurgedAt($purgedAt = null)
    {
        $this->purgedAt = $purgedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurgedAt()
    {
        return $this->purgedAt;
    }

    /**
     * @param mixed $sequenceId
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setSequenceId($sequenceId = null)
    {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @param mixed $sha1
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setSha1($sha1 = null)
    {
        $this->sha1 = $sha1;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSha1()
    {
        return $this->sha1;
    }

    /**
     * @param mixed $sharedLink
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setSharedLink($sharedLink = null)
    {
        $this->sharedLink = $sharedLink;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSharedLink()
    {
        return $this->sharedLink;
    }

    /**
     * @param mixed $size
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setSize($size = null)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $trashedAt
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setTrashedAt($trashedAt = null)
    {
        $this->trashedAt = $trashedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrashedAt()
    {
        return $this->trashedAt;
    }

    /**
     * @param mixed $type
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $versionNumber
     *
     * @return \Box\Model\File\File|\Box\Model\File\FileInterface
     */
    public function setVersionNumber($versionNumber = null)
    {
        $this->versionNumber = $versionNumber;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVersionNumber()
    {
        return $this->versionNumber;
    }

}
