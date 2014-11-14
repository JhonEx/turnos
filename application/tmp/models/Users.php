<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 */
class Users
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $last_access;

    /**
     * @var integer
     */
    private $admin;

    /**
     * @var string
     */
    private $language;

    /**
     * @var \DateTime
     */
    private $creationDate;

    /**
     * @var \models\Profiles
     */
    private $profile;

    /**
     * @var \models\UsersData
     */
    private $user_data;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set last_access
     *
     * @param \DateTime $lastAccess
     * @return Users
     */
    public function setLastAccess($lastAccess)
    {
        $this->last_access = $lastAccess;
    
        return $this;
    }

    /**
     * Get last_access
     *
     * @return \DateTime 
     */
    public function getLastAccess()
    {
        return $this->last_access;
    }

    /**
     * Set admin
     *
     * @param integer $admin
     * @return Users
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    
        return $this;
    }

    /**
     * Get admin
     *
     * @return integer 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Users
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Users
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set profile
     *
     * @param \models\Profiles $profile
     * @return Users
     */
    public function setProfile(\models\Profiles $profile = null)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return \models\Profiles 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set user_data
     *
     * @param \models\UsersData $userData
     * @return Users
     */
    public function setUserData(\models\UsersData $userData = null)
    {
        $this->user_data = $userData;
    
        return $this;
    }

    /**
     * Get user_data
     *
     * @return \models\UsersData 
     */
    public function getUserData()
    {
        return $this->user_data;
    }
}
