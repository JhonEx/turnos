<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Turns
 */
class Turns
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
     * @var \DateTime
     */
    private $initialTime;

    /**
     * @var \DateTime
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
     * Set name
     *
     * @param string $name
     * @return Turns
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
     * Set initialTime
     *
     * @param \DateTime $initialTime
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
     * @return \DateTime 
     */
    public function getInitialTime()
    {
        return $this->initialTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
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
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
}
