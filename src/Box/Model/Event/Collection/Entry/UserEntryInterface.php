<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:26 PM
 */

namespace Box\Model\Event\Collection\Entry;

interface UserEntryInterface extends EntryInterface
{
    public function getRecordedAt();
    public function setRecordedAt($recordedAt = null);
}