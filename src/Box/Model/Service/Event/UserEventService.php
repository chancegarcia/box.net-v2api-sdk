<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 6:22 PM
 */

namespace Box\Model\Service\Event;

use Box\Exception\BoxException;
use Box\Model\Event\Collection\EventCollection, Box\Model\Event\Collection\EventCollectionInterface;
use Box\Model\Event\User\UserEventInterface;
use Box\Model\Service\Service;
use Box\Model\Event\EventInterface, Box\Model\Event\Event;
use Box\Model\ModelInterface;

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
        if(!$this->isInt($streamPosition))
        {
            throw new BoxException('limit must be a valid integer value, (' . var_export($streamPosition, true) . ') given');
        }

        $this->streamPosition = $streamPosition;

        return $this;
    }

    public function getEvents($type = 'decoded', EventCollectionInterface $eventCollection = null)
    {
        $uri = $this->getEventsUri();

        $eventsData = $this->getFromBox($uri, $type);

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