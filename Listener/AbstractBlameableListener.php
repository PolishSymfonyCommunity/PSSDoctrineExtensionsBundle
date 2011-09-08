<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Listener;

use Doctrine\Common\EventSubscriber;

/**
 * AbstractBlameableListener.
 * 
 */
abstract class AbstractBlameableListener implements EventSubscriber
{
    /**
     * @var Driver $reader
     */
    protected $driver;

    /**
     * Sets driver.
     * 
     * @param Driver $driver The driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }
    
    /**
     * @var SecurityContext $securityContext
     */
    protected $securityContext;

    /**
     * Sets security context.
     * 
     * @param SecurityContext $securityContext The security context
     */
    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * The events the listener is subscribed to.
     * 
     * @return array An array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate'
        );
    }

    /**
     * 
     * @param Object $entity The entity
     * @param Blameable $blameable The blameable annotation
     * @param boolean $create
     */
    protected function updateEntity($entity, $blameable, $create = false)
    {
        $user = $this->securityContext->getToken()->getUser();
        if($user != null) {
            if(method_exists($user, 'getId')) {
                $userId = $user->getId();
            } else {
                $userId = $user->getUsername();
            }
        }

        if ($create) {
            // save user class name?
            // $entity->setUserClass($blameable->getUserClass());
            
            $creatorSetter = 'set' . $blameable->getCreator();
            $entity->$creatorSetter($userId);
        }

        $updaterSetter = 'set' . $blameable->getUpdater();
        $entity->$updaterSetter($userId);
    }

}