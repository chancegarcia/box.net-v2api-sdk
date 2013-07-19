<?php
/**
 * @package     Box
 * @subpackage  Box_Client
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Client;

class Client
{
    protected $_connection;
    protected $_folders;
    protected $_files;

    /**
     * allow for class injection by using an interface for these classes
     */
    protected $_folderClass;
    protected $_fileClass;
}
