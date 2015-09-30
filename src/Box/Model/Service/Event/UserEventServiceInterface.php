<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 6:48 PM
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
 * @method UserEventInterface getFromBox($uri = null, ModelInterface $class = null)
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

    public function getEvents(EventCollectionInterface $eventCollection = null);
    public function getEventsUri();

    /**
     * @return mixed
     */
    public function getOriginalEventsData();

    /**
     * @return boolean
     */
    public function returnOriginal();

    /**
     * @param boolean $returnOriginal
     *
     * @return UserEventServiceInterface
     */
    public function setReturnOriginal($returnOriginal = null);
}