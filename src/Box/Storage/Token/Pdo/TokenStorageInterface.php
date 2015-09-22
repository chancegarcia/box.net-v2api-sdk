<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 2:17 PM
 */

namespace Box\Storage\Token\Pdo;


use Box\Storage\Token\BaseTokenStorageInterface;
use PDO;

interface TokenStorageInterface extends BaseTokenStorageInterface
{
    public function getDsn();

    public function setDsn($dsn = null);

    public function getUsername();

    public function setUsername($username = null);

    public function getPassword();

    public function setPassword($password = null);

    public function getOptions();

    public function setOptions(array $options = null);

    public function getPdo();

    public function setPdo(PDO $pdo = null);

    public function getTokenTableName();

    public function setTokenTableName($tokenTableName = null);

    /**
     * @param null $tokenTableId
     *
     * @return TokenStorageInterface;
     */
    public function setTokenTableId($tokenTableId = null);

    public function getAdditionalTokenTableData();

    /**
     * @param array|\Traversable $additionalTokenTableData
     *
     * @return TokenStorageInterface
     */
    public function setAdditionalTokenTableData(array $additionalTokenTableData = null);

    /**
     * @return boolean
     */
    public function isUseCompositeKey();

    /**
     * @param boolean $useCompositeKey
     *
     * @return TokenStorageInterface
     */
    public function setUseCompositeKey($useCompositeKey = null);

    /**
     * @return array|\Traversable
     */
    public function getTokenCompositeKeyMap();

    /**
     * @param array|\Traversable $tokenCompositeKeyMap
     *
     * @return TokenStorageInterface
     */
    public function setTokenCompositeKeyMap($tokenCompositeKeyMap = null);

    /**
     * @return array|\Traversable
     */
    public function getTokenMap();

    /**
     * @param array|\Traversable $tokenMap
     *
     * @return TokenStorageInterface
     */
    public function setTokenMap($tokenMap = null);
}