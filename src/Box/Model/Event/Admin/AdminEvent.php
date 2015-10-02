<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/17/15
 * Time: 5:31 PM
 */

namespace Box\Model\Event\Admin;


use Box\Model\Event\Event;

/**
 * Class AdminEvent
 * @package Box\Model\Event\Admin
 */
class AdminEvent extends Event implements AdminEventInterface
{
    private $streamType;

    protected $limit = 100;
    protected $streamPosition;
    protected $createdAfter;
    protected $createdBefore;

    public function __construct(array $options = array())
    {
        $this->streamType = self::STREAM_TYPE;
        return parent::__construct($options);
    }

    /**
     * remove any attempt to map to the private property
     *
     * {@inheritdoc}
     */
    public function mapBoxToClass($aData)
    {
        // @todo need to refactor base model to explicitly take an array as the argument
        if (is_array($aData) && array_key_exists('stream_type'))
        {
            unset($aData['stream_type']);
        }
        else if (is_object($aData))
        {
            unset($aData->stream_type);
        }

        return parent::mapBoxToClass($aData);
    }

    /**
     * {@inheritdoc}
     */
    public function getStreamType()
    {
        return $this->streamType;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit($limit = null)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreamPosition()
    {
        return $this->streamPosition;
    }

    /**
     * {@inheritdoc}
     */
    public function setStreamPosition($streamPosition = null)
    {
        $this->streamPosition = $streamPosition;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAfter()
    {
        return $this->createdAfter;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAfter($createdAfter = null)
    {
        $this->createdAfter = $createdAfter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedBefore()
    {
        return $this->createdBefore;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedBefore($createdBefore = null)
    {
        $this->createdBefore = $createdBefore;

        return $this;
    }

    // GET


}