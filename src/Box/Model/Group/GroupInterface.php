<?php
/**
 * @package     Box
 * @subpackage  Box_Group
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Group;

interface GroupInterface {
    public function __construct($options = null);
    public function getId();
    public function mapBoxToClass($aData);
}
