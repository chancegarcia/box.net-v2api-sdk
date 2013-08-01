<?php
/**
 * @package     Box
 * @subpackage  Box_Collaboration
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Collaboration;

interface CollaborationInterface {
    public function getId();
    public function mapBoxToClass($aData);
}
