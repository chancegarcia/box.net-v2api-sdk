<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:20 PM
 */

namespace Box\Model\Event\Collection\Entry;

interface EntryInterface
{
    public function getSource();

    public function setSource($source = null);

    public function getCreatedBy();

    public function setCreatedBy($createdBy = null);

    public function getCreatedAt();

    public function setCreatedAt($createdAt = null);

    public function getEventId();

    public function setEventId($eventId = null);

    public function getEventType();

    public function setEventType($eventType = null);

    public function getType();

    public function setType($type = null);

    public function getSessionId();

    public function setSessionId($sessionId = null);
}