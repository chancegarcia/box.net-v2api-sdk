<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:51 PM
 */

namespace Box\Item\SharedLink\Permissions;

use Box\Model\Item\SharedLink\Permissions\PermissionsInterface;
use Box\Model\Model;

class Permissions extends Model implements PermissionsInterface
{
    protected $canDownload;
    protected $canPreview;

    /**
     * {@inheritdoc}
     */
    public function getCanDownload()
    {
        return $this->canDownload;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanDownload($canDownload = null)
    {
        $this->canDownload = $canDownload;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCanPreview()
    {
        return $this->canPreview;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanPreview($canPreview = null)
    {
        $this->canPreview = $canPreview;

        return $this;
    }
}