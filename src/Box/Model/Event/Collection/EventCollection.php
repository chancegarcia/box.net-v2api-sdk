<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 12:24 PM
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

namespace Box\Model\Event\Collection;

use Box\Collection\ArrayCollection;
use Box\Collection\ArrayCollectionInterface;
use Box\Exception\BoxException;
use Box\Model\Model;
use Box\Model\ModelInterface;

class EventCollection extends Model implements EventCollectionInterface
{
    protected $chunkSize;
    protected $nextStreamPosition;

    /**
     * @var ArrayCollectionInterface
     */
    protected $entries;
    protected $originalEntries;

    /**
     * {@inheritdoc}
     */
    public function getOriginalEntries()
    {
        return $this->originalEntries;
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalEntries($originalEntries = null)
    {
        $this->originalEntries = $originalEntries;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    /**
     * {@inheritdoc}
     */
    public function setChunkSize($chunkSize = null)
    {
        $this->chunkSize = $chunkSize;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextStreamPosition()
    {
        return $this->nextStreamPosition;
    }

    /**
     * {@inheritdoc}
     */
    public function setNextStreamPosition($nextStreamPosition = null)
    {
        $this->nextStreamPosition = $nextStreamPosition;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * {@inheritdoc}
     */
    public function setEntries($entries = null)
    {
        if (is_array($entries))
        {
            $this->originalEntries = $entries;
            $entries = new ArrayCollection($entries);
        }
        else
        {
            if (!$entries instanceof ArrayCollectionInterface)
            {
                throw new BoxException('entries must be an array or instance of ArrayCollectionInterface');
            }
        }

        $this->entries = $entries;

        return $this;
    }

}