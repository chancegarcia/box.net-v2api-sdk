<?php
/**
 * @package     Box
 * @subpackage  Box_Group
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2014 Chance Garcia, chancegarcia.com
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

namespace Box\Model\Group;

use Box\Model\Model;
use Box\Exception\BoxException;
use Box\Exception\GroupException;
use Box\Model\Group\GroupInterface;

class Group extends Model implements GroupInterface
{
    protected $type = 'group';
    protected $id;
    protected $name;
    protected $createdAt;
    protected $modifiedAt;

    public function getMembershipListUri($limit = 100, $offset = 0)
    {
        $selfId = $this->getId();
        if (!is_numeric($selfId))
        {
            throw new BoxException("Please set the folder Id to retrieve items for this folder.". BoxException::MISSING_ID);
        }

        if (!is_numeric($limit))
        {
            throw new BoxException("Limit must be a valid integer", BoxException::INVALID_INPUT);
        }

        if (!is_numeric($offset))
        {
            throw new BoxException("Offset must be a valid integer", BoxException::INVALID_INPUT);
        }

        $uri = self::URI . "/" . $selfId . "/memberships" . "?offset=" . $offset . "&limit=" . $limit;

        return $uri;
    }

    public function setId($id = null)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $createdAt
     * @return \Box\Model\Group\Group|\Box\Model\Group\GroupInterface
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
     * @param mixed $modifiedAt
     * @return \Box\Model\Group\Group|\Box\Model\Group\GroupInterface
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
     * @param mixed $name
     *
     * @throws GroupException
     * @return \Box\Model\Group\Group|\Box\Model\Group\GroupInterface
     */
    public function setName($name = null)
    {

        if (!is_string($name))
        {
            $name = null;
        } else if (strlen($name) > 255) {
            throw new GroupException(
                    "Box only supports group names of 255 characters or less. Names that will not be supported are the name “none” or a null name.",
                GroupException::INVALID_NAME
            );
        }

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


}
