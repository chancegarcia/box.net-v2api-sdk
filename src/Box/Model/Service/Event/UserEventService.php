<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 6:22 PM
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

use Box\Exception\BoxException;
use Box\Model\Event\Collection\EventCollection, Box\Model\Event\Collection\EventCollectionInterface;
use Box\Model\Event\User\UserEventInterface;
use Box\Model\Service\Service;
use Box\Model\Event\EventInterface, Box\Model\Event\Event;
use Box\Model\ModelInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UserEventService
 * @package Box\Model\Service
 *
 * can use the @method for letting IDEs know that they will get back and EventInterface
 */
class UserEventService extends Service implements UserEventServiceInterface
{
    protected $validStreamTypes = array(
        'all'
        /* returns everything */
        ,
        'changes'
        /* returns tree changes */
        ,
        'sync'
        /* returns tree changes only for sync folders */
    );

    protected $streamType = "all";
    protected $streamPosition = 0;
    protected $limit = self::LIMIT_DEFAULT;

    /**
     * {@inheritdoc}
     */
    public function getValidStreamTypes()
    {
        return $this->validStreamTypes;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreamType()
    {
        return $this->streamType;
    }

    /**
     * {@inheritdoc}
     */
    public function setStreamType($streamType = null)
    {
        $validStreamTypes = $this->getValidStreamTypes();
        if (!in_array($streamType, $validStreamTypes))
        {
            throw new BoxException("unexpect type ("
                                   . var_export($streamType, true)
                                   . ") valid types include: "
                                   . implode(", ", $validStreamTypes));
        }

        $this->streamType = $streamType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit($limit = null)
    {
        if (null === $limit)
        {
            $limit = self::LIMIT_DEFAULT;
        }

        if (!$this->isInt($limit))
        {
            throw new BoxException('limit must be a valid integer value, (' . var_export($limit, true) . ') given');
        }

        if ($limit > self::LIMIT_MAX)
        {
            $limit = self::LIMIT_MAX;
        }

        $this->limit = $limit;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreamPosition()
    {
        return $this->streamPosition;
    }

    /**
     * {@inheritdoc}
     * @throws \Box\Exception\BoxException
     */
    public function setStreamPosition($streamPosition = null)
    {
        if ("now" !== $streamPosition && !$this->isInt($streamPosition))
        {
            throw new BoxException('limit must be a valid integer value or "now", ('
                                   . var_export($streamPosition, true)
                                   . ') given');
        }

        $this->streamPosition = $streamPosition;

        return $this;
    }

    public function getEvents($type = 'decoded', EventCollectionInterface $eventCollection = null)
    {
        $uri = $this->getEventsUri();

        $eventsData = $this->getFromBox($uri, $type);
        if ($this->getLogger() instanceof LoggerInterface)
        {
            $this->getLogger()->debug('events data: ' . var_export($eventsData, true),
                                      array(
                                          __METHOD__ . ":" . __LINE__,
                                      ));
        }

        $returnData = null;

        if ($eventCollection instanceof ModelInterface)
        {
            $returnData = $eventCollection->mapBoxToClass($eventsData);
        }
        else
        {
            $returnData = $this->getLastResult($type);
        }

        return $returnData;
    }

    public function getEventsUri()
    {
        $uri = UserEventInterface::URI . "?"
               . "stream_type=" . $this->getStreamType()
               . "&"
               . "stream_position=" . $this->getStreamPosition()
               . "&"
               . "limit=" . $this->getLimit();

        return $uri;
    }
}