<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @Entity
 * @Table(name="holidays")
 */
class Holidays
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO") 
     */
    private $id;

    /**
     * @Column(type="date", unique=true, nullable=false) 
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
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    public function toArray()
    {
        $return = array();
        $return['id']           = $this->getId();
        $return['date']         = "";
        
        if (is_null($this->getDate()) == false){
            $return['date']    = $this->getDate()->format("Y-m-d");
        }
        
        return $return;
    }
}