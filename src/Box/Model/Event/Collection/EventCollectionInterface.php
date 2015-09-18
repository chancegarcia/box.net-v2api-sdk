<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 12:26 PM
 */

namespace Box\Model\Event\Collection;


use Box\Model\Collection\CollectionInterface;

interface EventCollectionInterface extends CollectionInterface
{
    /**
     * @return mixed
     */
    public function getChunkSize();

    /**
     * @param mixed $chunkSize
     *
     * @return EventCollectionInterface|EventCollection
     */
    public function setChunkSize($chunkSize = null);

    /**
     * @return mixed
     */
    public function getNextStreamPosition();

    /**
     * @param mixed $nextStreamPosition
     *
     * @return EventCollectionInterface|EventCollection
     */
    public function setNextStreamPosition($nextStreamPosition = null);
}