<?php
/**
 * @package     Box
 * @subpackage  Box_Group
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Group;

use Box\Model\ModelInterface;

interface GroupInterface extends ModelInterface
{
    const URI = "https://api.box.com/2.0/groups";
    const MEMBERSHIP_URI = "https://api.box.com/2.0/group_memberships";

    public function getId();
    public function getMembershipListUri($limit = 100, $offset = 0);
}
