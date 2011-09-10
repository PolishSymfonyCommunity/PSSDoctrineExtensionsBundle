<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Listener\ORM;

use PSS\Bundle\DoctrineExtensionsBundle\Listener\AbstractBlameableListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use PSS\Bundle\DoctrineExtensionsBundle\Annotation\Blameable;

/**
 * 
 *  Blameable ORM listener
 * 
 */
class BlameableListener extends AbstractBlameableListener
{

    /**
     * Set object creator & updater
     *
     * @param LifecycleEventArgs $args The event arguments
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $obj = $args->getEntity();
        $blameable = $this->driver->getBlameableAnnotation($obj);
        if (null !== $blameable) {
            $this->updateEntity($obj, $blameable, true);
        }
    }

    /**
     * Set object updater
     *
     * @param PreUpdateEventArgs $args The event arguments
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $obj = $args->getEntity();
        $blameable = $this->driver->getBlameableAnnotation($obj);
        if (null !== $blameable) {
            $this->updateEntity($obj, $blameable);

            $em = $args->getEntityManager();
            $uow = $em->getUnitOfWork();
            $metadata = $em->getClassMetadata(get_class($obj));
            $uow->recomputeSingleEntityChangeSet($metadata, $obj);
        }
    }

}