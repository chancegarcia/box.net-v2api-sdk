<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 12:26 PM
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

use Box\Collection\ArrayCollectionInterface;
use Box\Model\ModelInterface;

interface EventCollectionInterface extends ModelInterface
{
    /**
     * @return mixed
     */
    public function getChunkSize();

    /**
     * @param mixed $chunkSize
     *
     * @return EventCollectionInterface|EventCollection
     */
    public function setChunkSize($chunkSize = null);

    /**
     * @return mixed
     */
    public function getNextStreamPosition();

    /**
     * @param mixed $nextStreamPosition
     *
     * @return EventCollectionInterface|EventCollection
     */
    public function setNextStreamPosition($nextStreamPosition = null);

    /**
     * @return ArrayCollectionInterface
     */
    public function getEntries();

    /**
     * @param ArrayCollectionInterface|array $entries
     *
     * @return EventCollectionInterface
     */
    public function setEntries($entries = null);

    /**
     * @return mixed
     */
    public function getOriginalEntries();

    /**
     * @param mixed $originalEntries
     *
     * @return EventCollectionInterface
     */
    public function setOriginalEntries($originalEntries = null);
}