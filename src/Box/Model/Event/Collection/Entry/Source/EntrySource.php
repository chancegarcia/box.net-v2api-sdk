<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:34 PM
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

namespace Box\Model\Event\Collection\Entry\Source;

use Box\Model\Model;

class EntrySource extends Model implements SourceInterface
{
    protected $type;
    protected $id;
    protected $etag;
    protected $name;
    protected $createdAt;
    protected $modifiedAt;
    protected $description;
    protected $size;
    protected $createdBy;
    protected $modifiedBy;
    protected $ownedBy;
    protected $sharedLink;
    protected $parent;
    protected $itemStatus;
    protected $synced;
    protected $sequenceId;

    /**
     * @return mixed
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @param mixed $sequenceId
     *
     * @return SourceInterface
     */
    public function setSequenceId($sequenceId = null)
    {
        $this->sequenceId = $sequenceId;

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
     * @param mixed $type
     *
     * @return SourceInterface
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return SourceInterface
     */
    public function setId($id = null)
    {
        $this->id = $id;

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
     * @param mixed $etag
     *
     * @return SourceInterface
     */
    public function setEtag($etag = null)
    {
        $this->etag = $etag;

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
     * @param mixed $name
     *
     * @return SourceInterface
     */
    public function setName($name = null)
    {
        $this->name = $name;

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
     * @param mixed $createdAt
     *
     * @return SourceInterface
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

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
     * @param mixed $modifiedAt
     *
     * @return SourceInterface
     */
    public function setModifiedAt($modifiedAt = null)
    {
        $this->modifiedAt = $modifiedAt;

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
     * @param mixed $description
     *
     * @return SourceInterface
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

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
     * @param mixed $size
     *
     * @return SourceInterface
     */
    public function setSize($size = null)
    {
        $this->size = $size;

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
     * @param mixed $createdBy
     *
     * @return SourceInterface
     */
    public function setCreatedBy($createdBy = null)
    {
        $this->createdBy = $createdBy;

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
     * @param mixed $modifiedBy
     *
     * @return SourceInterface
     */
    public function setModifiedBy($modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

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
     * @param mixed $ownedBy
     *
     * @return SourceInterface
     */
    public function setOwnedBy($ownedBy = null)
    {
        $this->ownedBy = $ownedBy;

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
     * @param mixed $sharedLink
     *
     * @return SourceInterface
     */
    public function setSharedLink($sharedLink = null)
    {
        $this->sharedLink = $sharedLink;

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
     * @param mixed $parent
     *
     * @return SourceInterface
     */
    public function setParent($parent = null)
    {
        $this->parent = $parent;

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
     * @param mixed $itemStatus
     *
     * @return SourceInterface
     */
    public function setItemStatus($itemStatus = null)
    {
        $this->itemStatus = $itemStatus;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSynced()
    {
        return $this->synced;
    }

    /**
     * @param mixed $synced
     *
     * @return SourceInterface
     */
    public function setSynced($synced = null)
    {
        $this->synced = $synced;

        return $this;
    }
}