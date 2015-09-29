<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/18/15
 * Time: 12:24 PM
 */

namespace Box\Model\Event\Collection;


use Box\Collection\ArrayCollection;
use Box\Collection\ArrayCollectionInterface;
use Box\Exception\BoxException;
use Box\Model\Model;
use Box\Model\ModelInterface;

class EventCollection extends Model implements EventCollectionInterface
{
    protected $chunkSize;
    protected $nextStreamPosition;

    /**
     * @var ArrayCollection
     */
    protected $entries;
    protected $originalEntries;

    public function __construct(array $options = null)
    {
        parent::__construct($options);

        if (!$this->entries instanceof ArrayCollection)
        {
            $this->setOriginalEntries($this->entries);
            // @todo set mapper for collections
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalEntries()
    {
        return $this->originalEntries;
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalEntries($originalEntries = null)
    {
        $this->originalEntries = $originalEntries;

        return $this;
    }

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

    /**
     * {@inheritdoc}
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * {@inheritdoc}
     */
    public function setEntries($entries = null)
    {
        if (is_array($entries))
        {
            $entries = new ArrayCollection($entries);
        }
        else if (!$entries instanceof ArrayCollectionInterface)
        {
            throw new BoxException('entries must be an array or instance of ArrayCollectionInterface');
        }

        $this->entries = $entries;

        return $this;
    }


}