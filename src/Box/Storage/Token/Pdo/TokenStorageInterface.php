<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 9/22/15
 * Time: 2:17 PM
 * @package     Box
 * @subpackage  Box_Storage
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 Chance Garcia, chancegarcia.com
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