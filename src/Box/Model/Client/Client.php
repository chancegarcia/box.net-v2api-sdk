<?php
/**
 * @package     Box
 * @subpackage  Box_Client
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\Client;

use Box\Exception\Exception;
use Box\Model\Collaboration\Collaboration;
use Box\Model\Connection\Connection;
use Box\Model\Connection\ConnectionInterface;
use Box\Model\Connection\Token\Token;
use Box\Model\Connection\Token\TokenInterface;
use Box\Model\File\File;
use Box\Model\Folder\Folder;
use Box\Model\Folder\FolderInterface;
use Box\Model\Group\GroupInterface;
use Box\Model\Model;
use Box\Model\User\UserInterface;

/**
 * Class Client
 * @package Box\Model
 */
class Client extends Model
{
    CONST AUTH_URI = "https://www.box.com/api/oauth2/authorize";
    CONST TOKEN_URI = "https://www.box.com/api/oauth2/token";
    CONST REVOKE_URI = "https://www.box.com/api/oauth2/revoke";
    CONST SEARCH_URI = "https://api.box.com/2.0/search";

    protected $state;

    /**
     * @var Connection|ConnectionInterface
     */
    protected $connection;
    /**
     * @var array of folder items indexed by the folder ID
     * @internal should just be an array of any folder known/retrieved by the client. does not need to be recursive since folders know their parents and items
     */
    protected $folders;
    protected $files;
    /**
     * @var array of collaborations
     */
    protected $collaborations;

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
    protected $collaborationClass = 'Box\Model\Collaboration\Collaboration';
    protected $userClass = 'Box\Model\User\User';
    protected $groupClass = 'Box\Model\Group\Group';


    /**
     * @param mixed $options
     * @return Folder|FolderInterface
     */
    public function getNewFolder($options = null)
    {
        $oClass = $this->getNewClass('Folder',$options);

        return $oClass;
    }

    /**
     * @param mixed $options
     * @return \Box\Model\User\User|\Box\Model\User\UserInterface
     */
    public function getNewUser($options = null)
    {
        $oClass = $this->getNewClass('User',$options);
        return $oClass;
    }

    /**
     * @param mixed $options
     * @return \Box\Model\Group\Group|\Box\Model\Group\GroupInterface
     */
    public function getNewGroup($options = null)
    {
        $oClass = $this->getNewClass('Group',$options);
        return $oClass;
    }

    /**
     * @param mixed $options
     * @return \Box\Model\Collaboration\Collaboration|\Box\Model\Collaboration\CollaborationInterface
     */
    public function getNewCollaboration($options = null)
    {
        $oClass = $this->getNewClass('Collaboration',$options);
        return $oClass;
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

    /**
     * get membership list of a given group. if limit or offset is numeric, only retrieve specific list page;
     * @param null $group
     * @param null $limit leave null to get all; if limit is null but offset is numeric, limit will default to 100
     * @param null $offset leave null to get all; if limit is null but offset is numeric, limit will default to 100
     * @return array returns an array of User objects that are in the group membership
     * @return array returns an array of User objects that are in the group membership
     * @throws \Box\Exception\Exception
     */
    public function getGroupMembershipList($group = null, $limit = null, $offset = null)
    {
        if (is_numeric($group) && is_int($group))
        {
            $groupId = $group;
            $group = $this->getNewGroup();
            $group->setId($groupId);
        }

        if (!$group instanceof GroupInterface)
        {
            throw new Exception("Group object expected", Exception::INVALID_INPUT);
        }

        $members = array();
        $entries = array();

        if (is_numeric($limit) || is_numeric($offset)) {
            if (!is_numeric($limit))
            {
                $limit = 100;
            }

            $uri = $group->getMembershipListUri($limit, $offset);

            $data = $this->query($uri);

            $entries = $data['entries'];
        } else {
            $limit = 100;
            $offset = 0;

            $uri = $group->getMembershipListUri($limit, $offset);

            $data = $this->query($uri);

            $totalMembers = $data['total_count'];

            $entries = $data['entries'];

            $currentTotal = count($entries);

            while ($currentTotal < $totalMembers)
            {
                if (0 != $offset)
                {
                    $nextPage = $group->getMembershipListUri($limit, $offset);
                    $data = $this->query($nextPage);
                    $moreEntries = $data['entries'];
                    $entries = array_merge($entries, $moreEntries);

                    $currentTotal = count($entries);
                }

                $offset += $limit;
            }
        }

        foreach ($entries as $entry)
        {
            $userData = $entry['user'];
            $user = $this->getNewUser();
            $user->mapBoxToClass($userData);
            $members[] = $user;
        }

        return $members;
    }

    public function getFolderBySharedUri($sharedUri = null)
    {
        if (!is_string($sharedUri))
        {
            throw new Exception('shared uri must be a string value', Exception::INVALID_INPUT);
        }

        $uri = Folder::SHARED_ITEM_URI;
        $sSharedLinkHeader = "BoxApi: shared_link=" . $sharedUri;
        $aSharedLinkHeader = array($sSharedLinkHeader);

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection, $aSharedLinkHeader);

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
            $data['error_description'] = 'try refreshing the token';
            $this->error($data);
        }

        if (is_array($jsonData) && array_key_exists('type', $jsonData) && 'folder' === $jsonData['type'])
        {
            $folder = $this->getNewFolder();
            $folder->mapBoxToClass($jsonData);
        } else if (is_array($jsonData) && array_key_exists('type', $jsonData) && 'error' === $jsonData['type']) {
            $errorData['error'] = $jsonData['message'];
            $errorData['error_description'] = $jsonData;
            $this->error($errorData);
            $folder = null;
        } else {
            $folder = false;
        }

        return $folder;
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
            $data['error_description'] = 'try refreshing the token';
            $this->error($data);
        }

        $folder = $this->getNewFolder();
        $folder->mapBoxToClass($jsonData);

        return $folder;
    }

    /**
     * @param \Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface $folder
     * @param int                                                        $limit
     * @param int                                                        $offset
     * @return \Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface
     */
    public function getBoxFolderItems($folder, $limit = 100, $offset = 0)
    {
        $uri = $folder->getBoxFolderItemsUri($limit, $offset);
        $data = $this->query($uri);

        $folder->setItemCollection($data);

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

    /**
     * @param     $name
     * @param int $parentFolderId
     * @return Folder|FolderInterface
     */
    public function createNewBoxFolder($name,$parentFolderId = 0)
    {
        $uri = Folder::URI;

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $params = array(
            'name' => $name,
            'parent' => array('id' => $parentFolderId)
        );

        $data = $connection->post($uri,$params,true);

        $jsonData = json_decode($data,true);

        /**
         * error decoding json data
         */
        if (null === $jsonData)
        {
            $data = array();
            $data['error'] = "unable to decode json data";
            $data['error_description'] = 'try refreshing the token';
            $this->error($data);
        } else if (is_array($jsonData) && array_key_exists('type', $jsonData) && 'error' == $jsonData['type']) {
            $data = array();
            $data['error'] = $jsonData['status'] .  "  - " . $jsonData['code'];
            $data['error_description'] = var_export($jsonData['context_info'],true);
            $this->error($data);
        }

        $folder = $this->getNewFolder();
        $folder->mapBoxToClass($jsonData);

        return $folder;
    }

    /**
     * @param Folder|FolderInterface $folder
     * @param bool                   $ifMatchHeader
     * @throws \Exception
     * @return mixed
     */
    public function updateBoxFolder($folder,$ifMatchHeader=false)
    {
        $uri = Folder::URI . '/' . $folder->getId();

        // can't just do toArray(), only certain request attributes can be sent so have to send specialized param array.
        // @todo implement this to work. restubbing for now since toArray isn't working
        $params = $folder->toArray();
        throw new \Exception("currently not implemented/working.");

        // @todo implement If-Match header logic

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);
        $json = $connection->put($uri,$params, true);

        $data = json_decode($json,true);

        /**
         * error decoding json data
         */
        if (null === $data)
        {
            $errorData = array();
            $errorData['error'] = "unable to decode json data";
            $errorData['error_description'] = $data;
            $this->error($errorData);
        } else if (is_array($data) && array_key_exists('type', $data) && 'error' == $data['type']) {
            $errorData = array();
            $errorData['error'] = $data['status'] .  "  - " . $data['code'];
            $errorData['error_description'] = var_export($data['context_info'],true);
            $this->error($errorData);
        }

        return $data; // inconsistent? figure out what return is needed, if any
    }

    /**
     * @param null|\Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface $folder
     * @return mixed raw json data as an array
     */
    public function getFolderCollaborations($folder = null)
    {
        if (!$folder instanceof FolderInterface)
        {
            $err['error'] = 'sdk_unexpected_type';
            $err['error_description'] = "expecting FolderInterface class. given (" . var_export($folder,true) . ")";
            $this->error($err);
        }
        $folderId = $folder->getId();
        $uri = Folder::URI . '/' . $folderId . '/collaborations';

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $json = $connection->query($uri);

        $data = json_decode($json,true);

        // this can be refactored too...from copyBoxFolder
        if (null === $data) {
            $data['error'] = "sdk_json_decode";
            $data['error_description']  = "unable to decode or recursion level too deep";
            $this->error($data);
        } else if (array_key_exists('error',$data))
        {
            $this->error($data);
        } else if (array_key_exists('type',$data) && 'error' == $data['type']) {
            $data['error'] = "sdk_unknown";
            $ditto = $data;
            $data['error_description'] = $ditto;
            $this->error($data);
        }

        return $data;
    }

    /**
     * @param null|\Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface   $folder
     * @param null|\Box\Model\User\User|\Box\Model\User\UserInterface|\Box\Model\Group\GroupInterface           $collaborator
     * @param string                                                            $role see {@link http://developers.box.com/docs/#collaborations box documentation for all possible roles}
     * default is viewer
     * @return \Box\Model\Collaboration\Collaboration|\Box\Model\Collaboration\CollaborationInterface
     * @throws \Box\Exception\Exception
     */
    public function addCollaboration($folder = null, $collaborator = null, $role = 'viewer')
    {
        if (!$folder instanceof FolderInterface)
        {
            $err['error'] = 'sdk_unexpected_type';
            $err['error_description'] = "expecting FolderInterface class. given (" . var_export($folder,true) . ")";
            $this->error($err);
        }

        if (!$collaborator instanceof UserInterface && !$collaborator instanceof GroupInterface)
        {
            $err['error'] = 'sdk_unexpected_type';
            $err['error_description'] = "expecting UserInterface class. given (" . var_export($collaborator,true) . ")";
            $this->error($err);
        }

        $uri = Collaboration::URI;

        $folderId = $folder->getId();
        $collaboratorId = $collaborator->getId();

        $params = array(
            'item' => array(
                "id" => $folderId,
                "type" => "folder"
            ),
            'accessible_by' => array(
                "id" => $collaboratorId
            ),

            'role' => $role
        );

        // can be refactored a bit more but the json encode works in the connection class
        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $json = $connection->post($uri,$params,true);

        $data = json_decode($json,true);

        if (null === $data) {
            $data['error'] = "sdk_json_decode";
            $data['error_description']  = "unable to decode or recursion level too deep";
            $this->error($data);
        } else if (array_key_exists('error',$data))
        {
            $this->error($data);
        } else if (array_key_exists('type',$data) && 'error' == $data['type']) {
            $data['error'] = "sdk_unknown";
            $ditto = $data;
            $data['error_description'] = $ditto;
            $this->error($data);
        }

        $collaboration = $this->getNewCollaboration();
        $collaboration->mapBoxToClass($data);

        return $collaboration;
    }

    /**
     * @param null|\Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface $folder
     * @param array|null shared link options with
     * default shared link set to collaborator access, no unshared time or permissions set to
     * @return \Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface
     */
    public function createSharedLinkForFolder($folder = null, $params = null)
    {
        if (!$folder instanceof FolderInterface)
        {
            $err['error'] = 'sdk_unexpected_type';
            $err['error_description'] = "expecting FolderInterface class. given (" . var_export($folder,true) . ")";
            $this->error($err);
        }

        $uri = Folder::URI;

        $folderId = $folder->getId();

        $uri .= "/" . $folderId;

        if (!is_array($params))
        {
            $params = array(
                'shared_link' => array(
                    'access' => 'collaborators'
                )
            );
        }

        // can be refactored a bit more but the json encode works in the connection class
        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $json = $connection->put($uri,$params,true);

        $data = json_decode($json,true);

        if (null === $data) {
            $data['error'] = "sdk_json_decode";
            $data['error_description']  = "unable to decode or recursion level too deep";
            $this->error($data);
        } else if (array_key_exists('error',$data))
        {
            $this->error($data);
        } else if (array_key_exists('type',$data) && 'error' == $data['type']) {
            $data['error'] = "sdk_unknown";
            $ditto = $data;
            $data['error_description'] = $ditto;
            $this->error($data);
        }

        $updatedFolder = $this->getNewFolder();
        $updatedFolder->mapBoxToClass($data);

        return $updatedFolder;
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

        $json = $connection->post($uri,$params,true);

        $data = json_decode($json,true);

        if (null === $data) {
            $data['error'] = "sdk_json_decode";
            $data['error_description']  = "unable to decode or recursion level too deep";
            $this->error($data);
        } else if (array_key_exists('error',$data))
        {
            $this->error($data);
        } else if (array_key_exists('type',$data) && 'error' == $data['type']) {
            $data['error'] = "sdk_unknown";
            $ditto = $data;
            $data['error_description'] = $ditto;
            $this->error($data);
        }

        $copy = $this->getNewFolder();
        $copy->mapBoxToClass($data);

        if (true === $addToFolders && $copy instanceof Folder)
        {
            $this->addFolder($copy);
        }

        return $copy;
    }

    // @todo make multiple file upload
    public function uploadFileToBox($file)
    {
        $uri = File::UPLOAD_URI;

        // loop through the files and add the @ to the filename if not present

        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $uploaded = $connection->postFile($uri, $file);

        $data = json_decode($uploaded, true);

        if (array_key_exists('type',$data) && 'error' == $data['type']) {
            $data['error'] = "sdk_unknown";
            $ditto = $data;
            $data['error_description'] = $ditto;
            $this->error($data);
        }

        return $data;
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

        if (null === $data) {
            $data['error'] = "sdk_json_decode";
            $data['error_description']  = "unable to decode or recursion level too deep";
            $this->error($data);
        } else if (array_key_exists('error',$data))
        {
            $this->error($data);
        }

        $token = $this->getToken();
        $this->setTokenData($token , $data);

        return $token;

    }

    /**
     * @return \Box\Model\Connection\Token\Token|\Box\Model\Connection\Token\TokenInterface
     */
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

        if (null === $data) {
                    $data['error'] = "sdk_json_decode";
            $data['error_description']  = "unable to decode or recursion level too deep";
            $this->error($data);
        } else if (array_key_exists('error',$data))
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
     * @param $token \Box\Model\Connection\Token\TokenInterface|\Box\Model\Connection\Token\Token
     * @return mixed
     */
    public function destroyToken($token)
    {
        $params['client_id'] = $this->getClientId();
        $params['client_secret'] = $this->getClientSecret();
        // The access_token or refresh_token to be destroyed. Only one is required, though both will be destroyed.
        $params['token'] = $token->getAccessToken();

        $connection = $this->getConnection();

        $json = $connection->post(self::REVOKE_URI,$params);
        // @todo add error handling for null data
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
        if (null !== $state)
        {
            $params['state'] = $state;
        }

        $query = $this->buildQuery($params); // buildQuery does urlencode
        $uri .= $query;

        $redirectUri = $this->getRedirectUri();

        if (null !== $redirectUri)
        {
            $redirectUri = urlencode($redirectUri);
            $uri .= "&redirect_uri=" . $redirectUri;
        }

        return $uri;
    }

    /**
     * @param      $connection Connection
     * @param null|array $additionalHeaders
     * @return Connection
     * @throws Exception
     */
    public function setConnectionAuthHeader($connection, $additionalHeaders = null)
    {
        $headers = array($this->getAuthorizationHeader());

        if (null !== $additionalHeaders && !is_array($additionalHeaders))
        {
            throw new Exception('additional headers must be in array format', Exception::INVALID_INPUT);
        }

        if (is_array($additionalHeaders))
        {
            $headers = array_merge($headers, $additionalHeaders);
        }

        // header opt will require a merge with other headers to not overwrite.
        // @todo refactor to allow additional headers with auth header
        $connection->setCurlOpts(array('CURLOPT_HTTPHEADER' => $headers));
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

    public function setCollaborationClass($collaborationClass = null)
    {
        $this->validateClass($collaborationClass,'CollaborationInterface');
        $this->collaborationClass = $collaborationClass;
        return $this;
    }

    public function getCollaborationClass()
    {
        return $this->collaborationClass;
    }

    public function setUserClass($userClass = null)
    {
        $this->validateClass($userClass,'UserInterface');
        $this->userClass = $userClass;
        return $this;
    }

    public function getUserClass()
    {
        return $this->userClass;
    }

    public function setGroupClass($groupClass = null)
    {
        $this->validateClass($groupClass,'GroupInterface');
        $this->groupClass = $groupClass;
        return $this;
    }

    public function getGroupClass()
    {
        return $this->groupClass;
    }

    /**
     * @param array $collaborations
     * @return \Box\Model\Client\Client $this
     */
    public function setCollaborations($collaborations = null)
    {
        $this->collaborations = $collaborations;
        return $this;
    }

    /**
     * @return array
     */
    public function getCollaborations()
    {
        return $this->collaborations;
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
     * @param \Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface $root
     * @return \Box\Model\Client\Client
     */
    public function setRoot($root = null)
    {
        $this->root = $root;
        return $this;
    }

    /**
     * @return \Box\Model\Folder\Folder|\Box\Model\Folder\FolderInterface
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param $uri
     * @return mixed
     */
    public function query($uri = null)
    {
        $connection = $this->getConnection();
        $connection = $this->setConnectionAuthHeader($connection);

        $json = $connection->query($uri);

        $data = json_decode($json , true);

        if (null === $data)
        {
            $data['error'] = "sdk_json_decode";
            $data['error_description'] = "unable to decode or recursion level too deep";
            $this->error($data);
            return $data;
        }
        else if (array_key_exists('error' , $data))
        {
            $this->error($data);
            return $data;
        }
        else if (array_key_exists('type' , $data) && 'error' == $data['type'])
        {
            $data['error'] = "sdk_unknown";
            $ditto = $data;
            $data['error_description'] = $ditto;
            $this->error($data);
            return $data;
        }

        return $data;
    }

    public function search($query = null, $limit = null, $offset = null)
    {
        if (empty($query))
        {
            throw new Exception('please enter a search term', Exception::INVALID_INPUT);
        }

        $uriQuery = rawurlencode($query);

        $uri = self::SEARCH_URI . "/?query=" . $uriQuery;

        if (is_numeric($limit) && is_int($limit))
        {
            $uri .= "&limit=" . $limit;
        }

        if (is_numeric($offset) && is_int($offset))
        {
            $uri .= "&offset=" . $offset;
        }

        $data = $this->query($uri);

        return $data;
    }
}
