<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity;

use PSS\Bundle\DoctrineExtensionsBundle\Annotation as PSS;

/**
 * Non blameable entity.
 * 
 * 
 */
class NonBlameable
{
    /**
     * 
     * @var integer $id
     */
    protected $id;
    
    /**
     * 
     * @var string $name
     */
    protected $content;

    /**
     * 
     * @var type $creator
     */
    protected $creator;

    /**
     * 
     * @var type $updater
     */
    protected $updater;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($value)
    {
        $this->content = $value;
    }
    
    public function getUpdater()
    {
        return $this->updater;
    }

    public function setUpdater($value)
    {
        $this->updater = $value;
    }
    
    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator($value)
    {
        $this->creator = $value;
    }

}