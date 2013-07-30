<?php
/**
 * @package     Box
 * @subpackage  Box_Client
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Client;

use Box\Exception\Exception;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\File\FileInterface;
use Box\Model\Folder\FolderInterface;
use Box\Model\Connection\Connection;
use Box\Model\Connection\Token\Token;
use Box\Model\Model;
use Box\Model\Connection\Token\TokenInterface;
use Box\Model\Folder\Folder;

/**
 * Class Client
 * @package Box\Model
 * @todo implement getBoxFolderCollaborations in case we need to implement copy for collaborations too (unsure yet, depends if we find that collaborators aren't copied)
 */
class Client extends Model
{
    CONST AUTH_URI = "https://www.box.com/api/oauth2/authorize";
    CONST TOKEN_URI = "https://www.box.com/api/oauth2/token";
    CONST REVOKE_URI = "https://www.box.com/api/oauth2/revoke";

    protected $state;

    /**
     * @var Connection|ConnectionInterface
     */
    protected $connection;
    /**
     * @var array of folder items indexed by the folder ID
     */
    protected $folders;
    protected $files;

    /**
     * @var Folder
     */
    protected $root;

    /**
     * @var Token|TokenInterface
     */
    protected $token;

    protected $authorizationCode;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    protected $deviceId = null;
    protected $deviceName = null;


    /**
     * allow for class injection by using an interface for these classes
     */
    protected $folderClass = 'Box\Model\Folder\Folder';
    protected $fileClass = 'Box\Model\File\File';
    protected $connectionClass = 'Box\Model\Connection\Connection';
    protected $tokenClass = 'Box\Model\Connection\Token\Token';


    /**
     * @return Folder|FolderInterface
     */
    public function getNewFolder()
    {
        $sFolderClass = $this->getFolderClass();

        $oFolder = new $sFolderClass();

        return $oFolder;
    }

    /**
     * @param int $id use 0 for returning all folders
     * @param bool $retrieve if no folder is found, attempt to retrieve from box
     * @return array|null|Folder returns null if no such folder exists and retrieve is false
     */
    public function getFolder($id=0, $retrieve=true)
    {
        $folders = $this->getFolders($retrieve);

        if (0 == $id)
        {
            return $folders;
        }

        if (!array_key_exists($id,$folders))
        {
            if (!$retrieve)
            {
                return null;
            }
            $folder = $this->getFolderFromBox($id);
            $this->addFolder($folder);
        }


        $folder = $folders[$id];
        return $folder;

    }

    public function addFolder($folder)
    {
        $folders = $this->getFolders();
        array_push($folders,$folder);
        $this->setFolders($folders);

        return $this;
    }

    public function getFolders($retrieve=true)
    {
        if (!$retrieve)
        {
            return $this->folders;
        }

        $root = $this->getRoot();
        if (null === $root)
        {
            $root = $this->getFolderFromBox();
            $this->setRoot($root);
        }

        // not sure if I should add recursive parsing of folder/items. stubbing out for now.
        return null;

    }

    public function getFolderFromBox($id=0)
    {
        $uri = Folder::URI . '/' . $id; // all class constant URIs do not end in a slash

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $data = $connection->query($uri);

        $jsonData = json_decode($data,true);
        /**
         * API docs says error is thrown if folder does not exist or no access.
         * no example of error to parse by. Have to assume success until can modify
         */

        /**
         * error decoding json data
         */
        if (null === $jsonData)
        {
            $data['error'] = "unable to decode json data";
            $data['error_description'] = $jsonData;
            $this->error($data);
        }

        $folder = $this->getNewFolder();
        $folder->mapBoxToClass($jsonData);

        return $folder;
    }

    public function getFolderItems($id=0)
    {
        /**
         * @var Folder|FolderInterface $folder
         */
        $folder = $this->getFolder($id);

        return $folder->getItems();
    }

    public function createNewBoxFolder($name,$parent=array('id'=>0))
    {
        // stubbing this for now too
        return null;
    }

    /**
     * @param Folder|FolderInterface     $folder
     * @param bool $ifMatchHeader
     * @return mixed
     */
    public function updateBoxFolder($folder,$ifMatchHeader=false)
    {
        $uri = Folder::URI . '/' . $folder->getId();

        // @todo make param array from folder object. stubbing for now
        $params = array();

        // @todo implement If-Match header logic

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);
        $data = $connection->put($uri,$params);

        $jsonData = json_decode($data,true);

        /**
         * error decoding json data
         */
        if (null === $jsonData)
        {
            $data['error'] = "unable to decode json data";
            $data['error_description'] = $jsonData;
            $this->error($data);
        }

        return $data; // inconsistent? figure out what return is needed, if any
    }


    /**
     * @param Folder       $originalFolder
     * @param Folder|array $parent
     * @param string       $name
     * @param bool         $addToFolders
     * @return \Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface
     * @internal param $destinationId
     * @throws Exception
     */
    public function copyBoxFolder($originalFolder, $parent, $name=null, $addToFolders=true)
    {
        if (!$originalFolder instanceof FolderInterface)
        {
            $this->error(array('error'=>'Folder or FolderInterface expected','error_description'=>$originalFolder));
        }

        $uri = Folder::URI . '/' . $originalFolder->getId() . '/copy';

        if (is_array($parent))
        {
            $folder = $this->getNewFolder();
            $folder->mapBoxToClass($parent);
            $parent = $folder;
        }

        if (!$parent instanceof FolderInterface)
        {
            $this->error(array('error'=>'Folder or FolderInterface expected','error_description'=>$parent));
        }

        $params['parent'] = array('id'=>$parent->getId());
        if (null !== $name)
        {
            $params['name'] = $name;
        }

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $json = $connection->post($uri,$params);

        $data = json_decode($json,true);

        if (array_key_exists('error',$data))
        {
            $this->error($data);
        }

        $copy = $this->getNewFolder();
        $copy->mapBoxToClass($data);

        if ($addToFolders)
        {
            $this->addFolder($copy);
        }

        return $copy;
    }

    public function getAccessToken()
    {
        $connection = $this->getConnection();
        $params['grant_type'] = 'authorization_code';
        $params['code'] = $this->getAuthorizationCode();
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();

        $redirectUri = $this->getRedirectUri();
        if (null !== $redirectUri)
        {
            $params['redirect_uri'] = $redirectUri;
        }

        $json = $connection->post(self::TOKEN_URI,$params);

        $data = json_decode($json,true);

        if (array_key_exists('error',$data))
        {
            $this->error($data);
        }

        $token = $this->getToken();
        $this->setTokenData($token , $data);

        return $token;

    }

    public function refreshToken()
    {

        // outside script will set token via getAccessToken
        $token = $this->getToken();

        $params['refresh_token'] = $token->getRefreshToken();
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();
        $params['grant_type'] = 'refresh_token';

        $deviceId = $this->getDeviceId();
        if (null !== $deviceId)
        {
            $params['device_id'] = $deviceId;
        }

        $deviceName = $this->getDeviceName();
        if (null !== $deviceName)
        {
            $params['device_name'] = $deviceName;
        }

        $connection = $this->getConnection();

        $json = $connection->post(self::TOKEN_URI,$params);
        $data = json_decode($json,true);

        if (array_key_exists('error',$data))
        {
            $this->error($data);
        }

        $this->setTokenData($token,$data);

        $this->setToken($token);

        return $token;

    }

    public function getAuthorizationHeader()
    {
        $token = $this->getToken();

        $header = "Authorization: Bearer " . $token->getAccessToken();

        return $header;
    }

    /**
     * @param $token \Box\Model\Connection\Token\TokenInterface
     * @param $data
     * @return \Box\Model\Connection\Token\TokenInterface
     */
    public function setTokenData($token , $data)
    {
        $token->setAccessToken($data['access_token']);
        $token->setExpiresIn($data['expires_in']);
        $token->setTokenType($data['token_type']);
        $token->setRefreshToken($data['refresh_token']);

        return $token;
    }

    /**
     * @param $token \Box\Model\Connection\Token\TokenInterface
     */
    public function destroyToken($token)
    {
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();
        $params['token'] = $token->getAccessToken();

        $connection = $this->getConnection();

        $json = $connection->post(self::REVOKE_URI,$params);
        $data = json_decode($json,true);

        return $data;
    }

    public function auth()
    {
        // build get query to auth uri
        $query = $this->buildAuthQuery();

        // send get query to auth uri (auth uri will redirect to app redirect uri)
        $connection = $this->getConnection();

        // can't get return data b/c of redirect
        $connection->query($query);
    }

    public function buildAuthQuery()
    {
        $uri = self::AUTH_URI . '?';
        $params = array();

        $params['response_type'] = "code";

        $clientId = $this->getClientId();
        $params['client_id'] = $clientId;

        $state = $this->getState();
        $params['state'] = $state;

        $query = $this->buildQuery($params);
        $uri .= '?' . $query;

        $redirectUri = $this->getRedirectUri();

        if (null !== $redirectUri)
        {
            $redirectUri = urlencode($redirectUri);
            $uri .= "&redirect_uri=" . $redirectUri;
        }

        return $uri;
    }

    /**
     * @param $connection Connection
     * @return Connection
     */
    public function setConnectionAuthHeader($connection)
    {
        $connection->setCurlOpts(array('CURLOPT_HTTPHEADER' => $this->getAuthorizationHeader()));
        return $connection;
        }

    public function setClientId($clientId = null)
    {
        $this->clientId = $clientId;
        return $this;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientSecret($clientSecret = null)
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function setRedirectUri($redirectUri = null)
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }


    public function setAuthorizationCode($authorizationCode = null)
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    public function setToken($token = null)
    {
        $this->token = $token;
        return $this;
    }

    public function getToken()
    {
        if (null === $this->token)
        {
            $tokenClass = $this->getTokenClass();
            $token = new $tokenClass();
            $this->token = $token;
        }
        return $this->token;
    }

    public function setTokenClass($tokenClass = null)
    {
        $this->validateClass($tokenClass,'TokenInterface');
        $this->tokenClass = $tokenClass;
        return $this;
    }

    public function getTokenClass()
    {
        return $this->tokenClass;
    }

    public function setConnectionClass($connectionClass = null)
    {
        $this->validateClass($connectionClass,'ConnectionInterface');

        $this->connectionClass = $connectionClass;

        return $this;
    }

    public function getConnectionClass()
    {
        return $this->connectionClass;
    }

    public function setConnection($connection = null)
    {
        if (!$connection instanceof ConnectionInterface)
        {
            throw new Exception("Invalid Class",Exception::INVALID_CLASS);
        }
        $this->connection = $connection;
        return $this;
    }

    public function getConnection()
    {
        if (null === $this->connection)
        {
            $connectionClass = $this->getConnectionClass();
            $connection = new $connectionClass();
            $this->connection = $connection;
        }

        return $this->connection;
    }

    public function setFileClass($fileClass = null)
    {
        $this->validateClass($fileClass,'FileInterface');
        $this->fileClass = $fileClass;
        return $this;
    }

    public function getFileClass()
    {
        return $this->fileClass;
    }

    /**
     * @todo determine best validation for this
     * @param null $files
     * @return $this
     */
    public function setFiles($files = null)
    {
        $this->files = $files;
        return $this;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function setFolderClass($folderClass = null)
    {
        $this->validateClass($folderClass,'FolderInterface');
        $this->folderClass = $folderClass;
        return $this;
    }

    public function getFolderClass()
    {
        return $this->folderClass;
    }

    public function setFolders($folders = null)
    {
        $this->folders = $folders;
        return $this;
    }

    public function setDeviceId($deviceId = null)
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    public function getDeviceId()
    {
        return $this->deviceId;
    }

    public function setDeviceName($deviceName = null)
    {
        $this->deviceName = $deviceName;
        return $this;
    }

    public function getDeviceName()
    {
        return $this->deviceName;
    }

    public function setState($state = null)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    /**
     * @param \Box\Model\Folder\Folder $root
     */
    public function setRoot($root = null)
    {
        $this->root = $root;
        return $this;
    }

    /**
     * @return \Box\Model\Folder\Folder
     */
    public function getRoot()
    {
        return $this->root;
    }

}
