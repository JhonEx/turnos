<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Heyward Jimenez
 * @version 1.0
 * @created 23-Ene-2012 02:39:38 p.m.
 * 
 * @Entity
 * @Table(name="schedules")
 */
class Schedules
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO") 
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Turns")
     */
    private $turn;
    
    /**
     * @ManyToOne(targetEntity="UsersData")
     */
    private $user;

    /**
     * @Column(type="date", nullable=false) 
     */
    private $date;
    
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

    
    public function toArray()
    {
        $return = array();
        $return['id']   = $this->getId();
        $return['turn'] = $this->getTurn()->toArray();
        $return['user'] = $this->getUser()->toArray();
        $return['date'] = $this->getDate()->format("Y-m-d");
        
        return $return;
    }
}