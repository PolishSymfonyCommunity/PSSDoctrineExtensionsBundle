<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Driver\Blameable;

use Doctrine\Common\Annotations\Reader;

/**
 * Blameable AnnotationDriver.
 * 
 */
class AnnotationDriver
{
    /**
     * @var Reader $reader
     */
    private $reader;
    
    /**
     * Constructs a new intsance of AnnotationDriver.
     * 
     * @param Reader $reader The annotation reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * 
     * 
     * @param object $object The object
     * @return Blameable The blameable annotation
     */
    public function getBlameableAnnotation($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException();
        }

        $refClass = new \ReflectionClass($object);

        return $this->reader->getClassAnnotation($refClass, 'PSS\Bundle\DoctrineExtensionsBundle\Annotation\Blameable');    
    }

}