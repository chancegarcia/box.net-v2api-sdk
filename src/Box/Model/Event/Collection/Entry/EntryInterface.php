<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:20 PM
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