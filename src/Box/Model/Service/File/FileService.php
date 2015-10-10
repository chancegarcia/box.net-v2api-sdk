<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:32 PM
 */

namespace Box\Model\Service\File;

use Box\Model\File\File;
use Box\Model\File\FileInterface;
use Box\Model\Item\SharedLink\SharedLinkInterface;
use Box\Model\Service\Service;

class FileService extends Service implements FileServiceInterface
{
    protected $sharedLink;
    protected $access;

    public function createSharedLink(FileInterface $file = null, SharedLinkInterface $sharedLink = null)
    {
        $uri = $file::URI . "/" . $file->getId();

        $params = array(
            'shared_link' => $sharedLink->toBoxArray()
        );

        $updatedFile = $this->createNewFile();

        return $this->sendUpdateToBox($uri, $params, 'decoded', $updatedFile);
    }

    /**
     * @return FileInterface
     */
    public function createNewFile()
    {
        $file = new File();

        return $file;
    }
}