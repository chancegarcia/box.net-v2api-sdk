<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/29/15
 * Time: 3:27 PM
 */

namespace Box\Model\Event\Collection\Entry\Source;

use Box\Model\BoxModelInterface;

interface SourceInterface extends BoxModelInterface
{
    /**
     * @return mixed
     */
    public function getSynced();

    /**
     * @param mixed $synced
     *
     * @return BoxModelInterface
     */
    public function setSynced($synced = null);
}