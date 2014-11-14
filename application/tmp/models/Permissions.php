<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permissions
 */
class Permissions
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $in_menu;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var \models\Sections
     */
    private $section;


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
     * Set label
     *
     * @param string $label
     * @return Permissions
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Permissions
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set in_menu
     *
     * @param string $inMenu
     * @return Permissions
     */
    public function setInMenu($inMenu)
    {
        $this->in_menu = $inMenu;
    
        return $this;
    }

    /**
     * Get in_menu
     *
     * @return string 
     */
    public function getInMenu()
    {
        return $this->in_menu;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Permissions
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set section
     *
     * @param \models\Sections $section
     * @return Permissions
     */
    public function setSection(\models\Sections $section = null)
    {
        $this->section = $section;
    
        return $this;
    }

    /**
     * Get section
     *
     * @return \models\Sections 
     */
    public function getSection()
    {
        return $this->section;
    }
}
