<?php
/**
 * @package     Box
 * @subpackage  Box_User
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\User;

interface UserInterface {
    public function getId();
    public function mapBoxToClass($aData);
}
