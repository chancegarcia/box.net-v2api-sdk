<?php
/**
 * @package     Box
 * @subpackage  Box_Collaboration
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Collaboration;

use Box\Model\ModelInterface;

interface CollaborationInterface extends ModelInterface
{
    const URI = "https://api.box.com/2.0/collaborations";

    public function getId();
}
