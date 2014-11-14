<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedules
 */
class Schedules
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \models\Turns
     */
    private $turn;

    /**
     * @var \models\UsersData
     */
    private $user;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Schedules
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set turn
     *
     * @param \models\Turns $turn
     * @return Schedules
     */
    public function setTurn(\models\Turns $turn = null)
    {
        $this->turn = $turn;
    
        return $this;
    }

    /**
     * Get turn
     *
     * @return \models\Turns 
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * Set user
     *
     * @param \models\UsersData $user
     * @return Schedules
     */
    public function setUser(\models\UsersData $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \models\UsersData 
     */
    public function getUser()
    {
        return $this->user;
    }
}
