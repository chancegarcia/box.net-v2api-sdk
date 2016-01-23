<?php
/**
 * @package     Box
 * @subpackage  Box_Group
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
 *
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
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
