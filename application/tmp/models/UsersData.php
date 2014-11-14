<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersData
 */
class UsersData
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $identification;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var \models\Users
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $turns;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->turns = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set identification
     *
     * @param string $identification
     * @return UsersData
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    
        return $this;
    }

    /**
     * Get identification
     *
     * @return string 
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return UsersData
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set user
     *
     * @param \models\Users $user
     * @return UsersData
     */
    public function setUser(\models\Users $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \models\Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add turns
     *
     * @param \models\Schedules $turns
     * @return UsersData
     */
    public function addTurn(\models\Schedules $turns)
    {
        $this->turns[] = $turns;
    
        return $this;
    }

    /**
     * Remove turns
     *
     * @param \models\Schedules $turns
     */
    public function removeTurn(\models\Schedules $turns)
    {
        $this->turns->removeElement($turns);
    }

    /**
     * Get turns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTurns()
    {
        return $this->turns;
    }
}
