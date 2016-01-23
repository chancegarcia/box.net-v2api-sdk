<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 6:48 PM
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

namespace Box\Model\Service\Event;


use Box\Model\Event\Collection\EventCollectionInterface;
use Box\Model\Service\ServiceInterface;
use Box\Model\Event\User\UserEventInterface;
use Box\Model\ModelInterface;

/**
 * Interface UserEventServiceInterface
 * @package Box\Model\Service\Event
 *
 * use magic method doc for IDEs to know they're getting a specific ModelInterface
 */
interface UserEventServiceInterface extends ServiceInterface
{
    const LIMIT_MAX = 800;
    const LIMIT_DEFAULT = 100;

    /**
     * @return array
     */
    public function getValidStreamTypes();

    /**
     * @return string
     */
    public function getStreamType();

    /**
     * @param string $streamType
     *
     * @return UserEventServiceInterface
     */
    public function setStreamType($streamType = null);

    /**
     * @return int
     */
    public function getLimit();

    /**
     * @param int|null $limit set null to reset to default value
     *
     * @return UserEventServiceInterface
     */
    public function setLimit($limit = null);

    /**
     * @return int
     */
    public function getStreamPosition();

    /**
     * @param int $streamPosition
     * @return UserEventServiceInterface
     */
    public function setStreamPosition($streamPosition = null);

    public function getEvents($type = 'decoded', EventCollectionInterface $eventCollection = null);
    public function getEventsUri();
}