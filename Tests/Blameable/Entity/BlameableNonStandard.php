<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity;

use PSS\Bundle\DoctrineExtensionsBundle\Annotation as PSS;

/**
 * Non standard blameable entity.
 * 
 * 
 * @PSS\Blameable(creator="creator_id", updater="updater_id")
 */
class BlameableNonStandard
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
    protected $creator_id;

    /**
     * 
     * @var type $updater
     */
    protected $updater_id;

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
        return $this->updater_id;
    }

    public function setUpdater($value)
    {
        $this->updater_id = $value;
    }
    
    public function getCreator()
    {
        return $this->creator_id;
    }

    public function setCreator($value)
    {
        $this->creator_id = $value;
    }

}