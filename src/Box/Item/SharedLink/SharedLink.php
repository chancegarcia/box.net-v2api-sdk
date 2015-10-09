<?php
/**
 * Created by PhpStorm.
 * User: chance
 * Date: 10/9/15
 * Time: 5:48 PM
 */

namespace Box\Item\SharedLink;

use Box\Model\Item\SharedLink\Permissions\PermissionsInterface;
use Box\Model\Item\SharedLink\SharedLinkInterface;
use Box\Model\Model;

class SharedLink extends Model implements SharedLinkInterface
{
    protected $access;
    protected $unsharedAt;
    protected $password;
    protected $permissions;
    protected $effectiveAccess;

    /**
     * {@inheritdoc}
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccess($access = null)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnsharedAt()
    {
        return $this->unsharedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUnsharedAt($unsharedAt = null)
    {
        $this->unsharedAt = $unsharedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function setPermissions(PermissionsInterface $permissions = null)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEffectiveAccess()
    {
        return $this->effectiveAccess;
    }
}