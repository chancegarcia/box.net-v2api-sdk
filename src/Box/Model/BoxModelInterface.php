<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:31 PM
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

interface BoxModelInterface
{
    /**
     * @return mixed
     */
    public function getType();
    
    /**
     * @param mixed $type
     *
     * @return BoxModelInterface
     */
    public function setType($type = null);
    
    /**
     * @return mixed
     */
    public function getId();
    
    /**
     * @param mixed $id
     *
     * @return BoxModelInterface
     */
    public function setId($id = null);
    
    /**
     * @return mixed
     */
    public function getSequenceId();
    
    /**
     * @param mixed $sequenceId
     *
     * @return BoxModelInterface
     */
    public function setSequenceId($sequenceId = null);
    
    /**
     * @return mixed
     */
    public function getEtag();
    
    /**
     * @param mixed $etag
     *
     * @return BoxModelInterface
     */
    public function setEtag($etag = null);
    
    /**
     * @return mixed
     */
    public function getName();
    
    /**
     * @param mixed $name
     *
     * @return BoxModelInterface
     */
    public function setName($name = null);
    
    /**
     * @return mixed
     */
    public function getDescription();
    
    /**
     * @param mixed $description
     *
     * @return BoxModelInterface
     */
    public function setDescription($description = null);
    
    /**
     * @return mixed
     */
    public function getSize();
    
    /**
     * @param mixed $size
     *
     * @return BoxModelInterface
     */
    public function setSize($size = null);
    
    /**
     * @return mixed
     */
    public function getCreatedAt();
    
    /**
     * @param mixed $createdAt
     *
     * @return BoxModelInterface
     */
    public function setCreatedAt($createdAt = null);
    
    /**
     * @return mixed
     */
    public function getModifiedAt();
    
    /**
     * @param mixed $modifiedAt
     *
     * @return BoxModelInterface
     */
    public function setModifiedAt($modifiedAt = null);
    
    /**
     * @return mixed
     */
    public function getCreatedBy();
    
    /**
     * @param mixed $createdBy
     *
     * @return BoxModelInterface
     */
    public function setCreatedBy($createdBy = null);
    
    /**
     * @return mixed
     */
    public function getModifiedBy();
    
    /**
     * @param mixed $modifiedBy
     *
     * @return BoxModelInterface
     */
    public function setModifiedBy($modifiedBy = null);
    
    /**
     * @return mixed
     */
    public function getOwnedBy();
    
    /**
     * @param mixed $ownedBy
     *
     * @return BoxModelInterface
     */
    public function setOwnedBy($ownedBy = null);
    
    /**
     * @return mixed
     */
    public function getSharedLink();
    
    /**
     * @param mixed $sharedLink
     *
     * @return BoxModelInterface
     */
    public function setSharedLink($sharedLink = null);
    
    /**
     * @return mixed
     */
    public function getParent();
    
    /**
     * @param mixed $parent
     *
     * @return BoxModelInterface
     */
    public function setParent($parent = null);
    
    /**
     * @return mixed
     */
    public function getItemStatus();
    
    /**
     * @param mixed $itemStatus
     *
     * @return BoxModelInterface
     */
    public function setItemStatus($itemStatus = null);
    
}