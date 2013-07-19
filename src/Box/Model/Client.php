<?php
/**
 * @package     Box
 * @subpackage  Box_Client
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Client;

use Box\Exception;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\File\FileInterface;
use Box\Model\Folder\FolderInterface;

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
    protected $_connectionClass;

    public function setConnectionClass($connectionClass = null)
    {
        $this->validateClass($connectionClass,'ConnectionInterface');

        $this->_connectionClass = $connectionClass;

        return $this;
    }

    public function getConnectionClass()
    {
        return $this->_connectionClass;
    }

    public function setConnection($connection = null)
    {
        if (!$connection instanceof ConnectionInterface)
        {
            throw new Exception("Invalid Class",Exception::INVALID_CLASS);
        }
        $this->_connection = $connection;
        return $this;
    }

    public function getConnection()
    {
        return $this->_connection;
    }

    public function setFileClass($fileClass = null)
    {
        $this->validateClass($fileClass,'FileInterface');
        $this->_fileClass = $fileClass;
        return $this;
    }

    public function getFileClass()
    {
        return $this->_fileClass;
    }

    /**
     * @todo determine best validation for this
     * @param null $files
     * @return $this
     */
    public function setFiles($files = null)
    {
        $this->_files = $files;
        return $this;
    }

    public function getFiles()
    {
        return $this->_files;
    }

    public function setFolderClass($folderClass = null)
    {
        $this->validateClass($folderClass,'FolderInterface');
        $this->_folderClass = $folderClass;
        return $this;
    }

    public function getFolderClass()
    {
        return $this->_folderClass;
    }

    public function setFolders($folders = null)
    {
        $this->_folders = $folders;
        return $this;
    }

    public function getFolders()
    {
        return $this->_folders;
    }


    public function getFolder()
    {
        $sFolderClass = $this->getFolderClass();

        $oFolder = new $sFolderClass();

        return $oFolder;
    }

    /**
     * @param string $class
     * @param  string $classType
     * @throws \Box\Exception
     * @return bool returns true if validation passes. Throws exception if unable to validate or validation doesn't pass
     */
    public function validateClass($class,$classType)
    {
        if (!is_string($class))
        {
            throw new Exception("Please specify a class string to validate",Exception::INVALID_INPUT);
        }

        if (!is_string($classType))
        {
            throw new Exception("Unable to validate. Please specify a class type to validate",Exception::INVALID_CLASS_TYPE);
        }

        if (!class_exists($class))
        {
            throw new Exception("Unable to find class" , Exception::UNKNOWN_CLASS);
        }
        else
        {
            $oClass = new $class();
        }

        if (!$oClass instanceof $classType)
        {
            throw new Exception("Invalid Connection Class" , Exception::INVALID_CLASS_TYPE);
        }

        return true;
    }
}
