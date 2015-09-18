<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 12:24 PM
 */

namespace Box\Model\Event\Collection;


use Box\Model\Collection\Collection;

class EventCollection extends Collection implements EventCollectionInterface
{
    protected $chunkSize;
    protected $nextStreamPosition;

    /**
     * {@inheritdoc}
     */
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    /**
     * {@inheritdoc}
     */
    public function setChunkSize($chunkSize = null)
    {
        $this->chunkSize = $chunkSize;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextStreamPosition()
    {
        return $this->nextStreamPosition;
    }

    /**
     * {@inheritdoc}
     */
    public function setNextStreamPosition($nextStreamPosition = null)
    {
        $this->nextStreamPosition = $nextStreamPosition;

        return $this;
    }
}