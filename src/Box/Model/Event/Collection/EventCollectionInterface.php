<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 12:26 PM
 */

namespace Box\Model\Event\Collection;

use Box\Collection\ArrayCollectionInterface;
use Box\Model\ModelInterface;

interface EventCollectionInterface extends ModelInterface
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

    /**
     * @return ArrayCollectionInterface
     */
    public function getEntries();

    /**
     * @param ArrayCollectionInterface|array $entries
     * @return EventCollectionInterface
     */
    public function setEntries($entries = null);
}