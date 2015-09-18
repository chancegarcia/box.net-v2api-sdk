<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:27 PM
 */

namespace Box\Model\Event;


interface EventInterface
{
    public function getType();
    public function setType($type = null);
    public function getEventId();
    public function setEventId($eventId = null);
    public function getCreatedBy();
    public function setCreatedBy($createdBy = null);
    public function getEventType();
    public function setEventType($eventType = null);
    public function getSessionId();
    public function setSessionId($sessionId = null);
    public function getSource();
    public function setSource($source = null);
}