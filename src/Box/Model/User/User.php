<?php
/**
 * @package     Box
 * @subpackage  Box_User
 * @author      Chance Garcia
 * @copyright   (C)Copyright 2013 chancegarcia.com
 */

namespace Box\Model\User;

use Box\Model\Model;
use Box\Exception\BoxException;
use Box\Model\User\UserInterface;

class User extends Model implements UserInterface
{
    protected $type = "user";
    protected $id;
    protected $name;
    protected $login;
    protected $createdAt;
    protected $modifiedAt;
    protected $role; // admin, coadmin, user only
    protected $language;
    protected $spaceAmount;
    protected $spaceUsed;
    protected $maxUploadSize;
    protected $trackingCodes;
    protected $canSeeManagedUsers;
    protected $isSyncEnabled;
    protected $status;
    protected $jobTitle;
    protected $phone;
    protected $address;
    protected $avatarUrl;
    protected $isExemptFromDeviceLimits;
    protected $isExemptFromLoginVerification;
    protected $enterprise;

    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAvatarUrl($avatarUrl = null)
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    public function setCanSeeManagedUsers($canSeeManagedUsers = null)
    {
        $this->canSeeManagedUsers = $canSeeManagedUsers;

        return $this;
    }

    public function getCanSeeManagedUsers()
    {
        return $this->canSeeManagedUsers;
    }

    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setEnterprise($enterprise = null)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    public function getEnterprise()
    {
        return $this->enterprise;
    }

    public function setIsExemptFromDeviceLimits($isExemptFromDeviceLimits = null)
    {
        $this->isExemptFromDeviceLimits = $isExemptFromDeviceLimits;

        return $this;
    }

    public function getIsExemptFromDeviceLimits()
    {
        return $this->isExemptFromDeviceLimits;
    }

    public function setIsExemptFromLoginVerification($isExemptFromLoginVerification = null)
    {
        $this->isExemptFromLoginVerification = $isExemptFromLoginVerification;

        return $this;
    }

    public function getIsExemptFromLoginVerification()
    {
        return $this->isExemptFromLoginVerification;
    }

    public function setIsSyncEnabled($isSyncEnabled = null)
    {
        $this->isSyncEnabled = $isSyncEnabled;

        return $this;
    }

    public function getIsSyncEnabled()
    {
        return $this->isSyncEnabled;
    }

    public function setJobTitle($jobTitle = null)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    public function setLanguage($language = null)
    {
        $this->language = $language;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLogin($login = null)
    {
        $this->login = $login;

        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setMaxUploadSize($maxUploadSize = null)
    {
        $this->maxUploadSize = $maxUploadSize;

        return $this;
    }

    public function getMaxUploadSize()
    {
        return $this->maxUploadSize;
    }

    public function setModifiedAt($modifiedAt = null)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setRole($role = null)
    {
        $this->role = $role;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setSpaceAmount($spaceAmount = null)
    {
        $this->spaceAmount = $spaceAmount;

        return $this;
    }

    public function getSpaceAmount()
    {
        return $this->spaceAmount;
    }

    public function setSpaceUsed($spaceUsed = null)
    {
        $this->spaceUsed = $spaceUsed;

        return $this;
    }

    public function getSpaceUsed()
    {
        return $this->spaceUsed;
    }

    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setTrackingCodes($trackingCodes = null)
    {
        $this->trackingCodes = $trackingCodes;

        return $this;
    }

    public function getTrackingCodes()
    {
        return $this->trackingCodes;
    }

    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }


}
