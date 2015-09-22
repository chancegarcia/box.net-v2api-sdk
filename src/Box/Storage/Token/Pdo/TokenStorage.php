<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 2:24 PM
 */

namespace Box\Storage\Token\Pdo;

use Box\Model\Connection\Token\Token;
use Box\Model\Connection\Token\TokenInterface;
use PDO;

/**
 * Class TokenStorage
 * @package Box\Storage\Pdo
 *
 * all string sql statements produced by this class auto-quote the columns and table
 * @todo finish this class
 */
class TokenStorage implements TokenStorageInterface
{
    protected $dsn;
    protected $username;
    protected $password;
    protected $options = array();
    protected $pdo;

    protected $tokenTableName = 'box_token';
    protected $tokenTableId = array('access_token', 'refresh_token');
    /**
     * map for persistence
     * @var array map contains the database column as the key and the token object getter method as the value.
     */
    protected $tokenMap = array(
        'access_token' => 'getAccessToken',
        'refresh_token' => 'getRefreshToken',
        'grant_type' => 'getGrantType',
        'expires_in' => 'getExpiresIn',
        'token_type' => 'getTokenType',
        'restricted_to' => 'getRestrictedTo',
    );
    protected $useCompositeKey = true;
    protected $tokenCompositeKeyMap = array(
        'access_token' => 'getAccessToken',
        ''
    );
    protected $additionalTokenTableData = array();

    /**
     * construct with pdo constructor arguments
     * @param null $dsn
     * @param null $username
     * @param null $password
     * @param array $options
     */
    public function __construct($dsn = null, $username = null, $password = null, $options = array())
    {
        $this->setDsn($dsn);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setOptions($options);

        $pdo = new PDO($dsn, $username, $password, $options);

        $this->setPdo($pdo);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * @param mixed $dsn
     *
     * @return TokenStorage
     */
    public function setDsn($dsn = null)
    {
        $this->dsn = $dsn;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return TokenStorage
     */
    public function setUsername($username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return TokenStorage
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return TokenStorage
     */
    public function setOptions(array $options = null)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     *
     * @return TokenStorage
     */
    public function setPdo(PDO $pdo = null)
    {
        $this->pdo = $pdo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTokenTableName()
    {
        return $this->tokenTableName;
    }

    /**
     * @param mixed $tokenTableName
     *
     * @return TokenStorage
     */
    public function setTokenTableName($tokenTableName = null)
    {
        $this->tokenTableName = $tokenTableName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTokenTableId()
    {
        return $this->tokenTableId;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenTableId($tokenTableId = null)
    {
        $this->tokenTableId = $tokenTableId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalTokenTableData()
    {
        return $this->additionalTokenTableData;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdditionalTokenTableData(array $additionalTokenTableData = null)
    {
        $this->additionalTokenTableData = $additionalTokenTableData;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isUseCompositeKey()
    {
        return $this->useCompositeKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setUseCompositeKey($useCompositeKey = null)
    {
        $this->useCompositeKey = $useCompositeKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenCompositeKeyMap()
    {
        return $this->tokenCompositeKeyMap;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenCompositeKeyMap($tokenCompositeKeyMap = null)
    {
        $this->tokenCompositeKeyMap = $tokenCompositeKeyMap;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenMap()
    {
        return $this->tokenMap;
    }

    /**
     * {@inheritdoc}
     */
    public function setTokenMap($tokenMap = null)
    {
        $this->tokenMap = $tokenMap;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function storeToken(TokenInterface $token)
    {
        $sql = "INSERT INTO `" . $this->getTokenTableName() . "`
                SET `";

        $tokenMap = $this->getTokenMap();

        $first = true;
        foreach ($tokenMap as $column =>$value)
        {
            $sql .= "`" . $this->getTokenTableName() . "`" . "`" . $column . "`"
                                . " = " ;

            if (false === $first)
            {
                $sql .= " AND ";
            }

        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateToken(TokenInterface $token, $tokenUpdateClause = null)
    {
        // TODO: Implement updateToken() method.
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveToken($retrievalWhereClause = null)
    {
        // TODO: Implement retrieveToken() method.
    }
}