<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:29 PM
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

namespace Box\Model;

class BoxModel implements BoxModelInterface
{
    protected $type;
    protected $id;
    protected $sequenceId;
    protected $etag;
    protected $name;
    protected $description;
    protected $size;
    protected $createdAt;
    protected $modifiedAt;
    protected $createdBy;
    protected $modifiedBy;
    protected $ownedBy;
    protected $sharedLink;
    protected $parent;
    protected $itemStatus;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    public function setSequenceId($sequenceId = null)
    {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    public function getEtag()
    {
        return $this->etag;
    }

    public function setEtag($etag = null)
    {
        $this->etag = $etag;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size = null)
    {
        $this->size = $size;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt($modifiedAt = null)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy($modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    public function getOwnedBy()
    {
        return $this->ownedBy;
    }

    public function setOwnedBy($ownedBy = null)
    {
        $this->ownedBy = $ownedBy;

        return $this;
    }

    public function getSharedLink()
    {
        return $this->sharedLink;
    }

    public function setSharedLink($sharedLink = null)
    {
        $this->sharedLink = $sharedLink;

        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getItemStatus()
    {
        return $this->itemStatus;
    }

    public function setItemStatus($itemStatus = null)
    {
        $this->itemStatus = $itemStatus;

        return $this;
    }

}