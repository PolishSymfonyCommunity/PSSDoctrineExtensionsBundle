<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Listener\ODM\MongoDB;

use PSS\Bundle\DoctrineExtensionsBundle\Listener\AbstractBlameableListener;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;

/**
 * 
 *  Blameable MongoDB listener
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
        $obj = $args->getDocument();

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
        $obj = $args->getDocument();

        $blameable = $this->driver->getBlameableAnnotation($obj);
        if (null !== $blameable) {
            $this->updateEntity($obj, $blameable);

            $dm = $args->getDocumentManager();
            $uow = $dm->getUnitOfWork();
            $metadata = $dm->getClassMetadata(get_class($obj));
            $uow->recomputeSingleDocumentChangeSet($metadata, $obj);
        }
    }

}