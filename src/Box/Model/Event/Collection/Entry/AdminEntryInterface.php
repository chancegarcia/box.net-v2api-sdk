<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:20 PM
 */

namespace Box\Model\Event\Collection\Entry;

interface AdminEntryInterface extends EntryInterface
{
    public function getIpAddress();
    public function setIpAddress($ipAddress = null);
}