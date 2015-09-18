<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:29 PM
 */

namespace Box\Model\Event;


use Box\Model\Model;

class Event extends Model implements EventInterface
{
    protected $type;

    protected $eventId;

    protected $createdBy;

    protected $eventType;

    protected $sessionId;

    protected $source;

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
     * @return EventInterface
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param mixed $eventId
     *
     * @return EventInterface
     */
    public function setEventId($eventId = null)
    {
        $this->eventId = $eventId;

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
     * @return EventInterface
     */
    public function setCreatedBy($createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     *
     * @return EventInterface
     */
    public function setEventType($eventType = null)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     *
     * @return EventInterface
     */
    public function setSessionId($sessionId = null)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     *
     * @return EventInterface
     */
    public function setSource($source = null)
    {
        $this->source = $source;

        return $this;
    }


}