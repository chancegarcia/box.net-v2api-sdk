<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:27 PM
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