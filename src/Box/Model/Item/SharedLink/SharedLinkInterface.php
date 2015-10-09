<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:47 PM
 */

namespace Box\Model\Item\SharedLink;

use Box\Model\ModelInterface;
use Box\Model\Item\SharedLink\Permissions\PermissionsInterface;

interface SharedLinkInterface extends ModelInterface
{
    /**
     * @return mixed
     */
    public function getEffectiveAccess();

    /**
     * @return mixed
     */
    public function getAccess();

    /**
     * @param mixed $access
     *
     * @return SharedLinkInterface
     */
    public function setAccess($access = null);

    /**
     * @return mixed
     */
    public function getUnsharedAt();

    /**
     * @param mixed $unsharedAt
     *
     * @return SharedLinkInterface
     */
    public function setUnsharedAt($unsharedAt = null);

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @param mixed $password
     *
     * @return SharedLinkInterface
     */
    public function setPassword($password = null);

    /**
     * @return null|PermissionsInterface
     */
    public function getPermissions();

    /**
     * @param PermissionsInterface $permissions
     *
     * @return SharedLinkInterface
     */
    public function setPermissions(PermissionsInterface $permissions = null);
}