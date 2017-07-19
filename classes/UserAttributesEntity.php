<?php

/**
 * 
 */
class UserAttributesEntity
{
    private $userId;

    private $defaultStationId;

    private $defaultStationName;

    private $preferredLines;

    private $lastContact;

    private $admin                  = false;

    public function __construct(string $userDataAsJson=false)
    {
        if(is_string($userDataAsJson) && strlen($userDataAsJson) > 0 ) {
            $userData = json_decode($userDataAsJson, $pAssoc=true);
            if(is_array($userData)) {
                foreach (array_keys(get_class_vars(__CLASS__)) as $attribute) {
                    if(array_key_exists($attribute, $userData)) {
                        $this->$attribute = $userData[$attribute];
                    }
                }
            }
        }
        // Update last contact
        $this->setLastContact();
    }

    public function __toString()
    {
        $attributes = array();
        foreach (array_keys(get_class_vars(__CLASS__)) as $attribute) {
            $attributes[$attribute] = $this->$attribute;
        }
        return json_encode($attributes, JSON_PRETTY_PRINT);
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getDefaultStationName()
    {
        return $this->defaultStationName;
    }

    /**
     * @param string $defaultStationName
     */
    public function setDefaultStationName(string $defaultStationName)
    {
        $this->defaultStationName = $defaultStationName;
    }

    /**
     * @return int
     */
    public function getDefaultStationId()
    {
        return $this->defaultStationId;
    }

    /**
     * @param int $defaultStationId
     */
    public function setDefaultStationId(int $defaultStationId)
    {
        $this->defaultStationId = $defaultStationId;
    }

    /**
     * @return array
     */
    public function getPreferredLines()
    {
        return $this->preferredLines;
    }

    /**
     * @param array $preferredLines
     */
    public function setPreferredLines($preferredLines)
    {
        $this->preferredLines = $preferredLines;
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param boolean $admin
     */
    public function setAdmin(bool $admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getLastContact()
    {
        return $this->lastContact;
    }

    /**
     * @param mixed $lastContact
     */
    public function setLastContact(int $lastContact=null)
    {
        if(is_null($lastContact)) {
            $lastContact = time();
        }
        $this->lastContact = $lastContact;
    }
}