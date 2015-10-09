<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:50 PM
 */

namespace Box\Model\Item\SharedLink\Permissions;

use Box\Model\ModelInterface;

interface PermissionsInterface extends ModelInterface
{
    /**
     * @return bool
     */
    public function getCanDownload();

    /**
     * @param bool $canDownload
     *
     * @return PermissionsInterface
     */
    public function setCanDownload($canDownload = null);

    /**
     * @return bool
     */
    public function getCanPreview();

    /**
     * @param bool $canPreview
     *
     * @return PermissionsInterface
     */
    public function setCanPreview($canPreview = null);
}