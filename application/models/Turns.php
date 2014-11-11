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
 * @Table(name="turns")
 */
class Turns
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO") 
     */
    private $id;

    /**
     * @Column(type="time", nullable=false) 
     */
    private $initialTime;

    /**
     * @Column(type="time", nullable=false) 
     */
    private $endTime;
    
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
     * Set inicialTime
     *
     * @param \Time $inicialTime
     * @return Turns
     */
    public function setInitialTime($initialTime)
    {
        $this->initialTime = $initialTime;
    
        return $this;
    }

    /**
     * Get initialTime
     *
     * @return \Time 
     */
    public function getInitialTime()
    {
        return $this->initialTime;
    }

    /**
     * Set endTime
     *
     * @param \Time $endTime
     * @return Turns
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return \Time 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    public function toArray()
    {
        $return = array();
        $return['id']           = $this->getId();
        $return['initial_time']         = "";
        $return['end_time']         = "";
        
        if (is_null($this->getInitialTime()) == false){
            $return['initial_time']    = $this->getInitialTime()->format("H-i");
        }
        
        if (is_null($this->getEndTime()) == false){
            $return['end_time']    = $this->getEndTime()->format("H:i");
        }
        
        return $return;
    }
}