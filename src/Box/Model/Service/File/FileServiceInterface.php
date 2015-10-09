<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:32 PM
 */

namespace Box\Model\Service\File;

use Box\Model\File\FileInterface;
use Box\Model\Item\SharedLink\SharedLinkInterface;
use Box\Model\Service\ServiceInterface;

interface FileServiceInterface extends ServiceInterface
{
    /**
     * @param FileInterface $file
     * @param SharedLinkInterface $sharedLink shared link object used to set box permissions
     *
     * @return FileInterface
     */
    public function createSharedLink(FileInterface $file = null, SharedLinkInterface $sharedLink = null);

    /**
     * @return FileInterface
     */
    public function createNewFile();
}