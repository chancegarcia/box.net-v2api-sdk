<?php
/**
 * @package     Box
 * @subpackage  Box_User
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\User;

use Box\Model\ModelInterface;

interface UserInterface extends ModelInterface
{
    const URI = 'https://api.box.com/2.0/users';
    const CURRENT_USER_URI = 'https://api.box.com/2.0/users/me';

    public function getId();
}
