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
     * @var Container $container
     */
    protected $container;

    /**
     * Sets Container.
     *
     * @param Container $container The DIC
     */
    public function setContainer($container)
    {
        $this->container = $container;
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
        if($blameable->getUserClass() === NULL) {
            if ($this->container->hasParameter('pss.blameable.user_class')) {
                $blameable->setUserClass($this->container->getParameter('pss.blameable.user_class'));
            } else {
                throw new \InvalidArgumentException('You must define a "userClass" attribute or "user_class" config.');
            }
        }

        $user = $this->container->get('security.context')->getToken()->getUser();
        if($user instanceof \Symfony\Component\Security\Core\User\UserInterface) {
            if(method_exists($user, 'getId')) {
                $userId = $user->getId();
            } else {
                $userId = $user->getUsername();
            }
        } else {
            $userId = NULL;
        }

        if ($create) {
            // save user class name?
            // $entity->setUserClass($blameable->getUserClass());

            $creatorSetter = 'set' . $blameable->getCreator();

            // Test to store the object or the id/username
            if ($this->container->getParameter('pss.blameable.store_object')) {
                $entity->$creatorSetter($user ? $user : null);
            } else {
                $entity->$creatorSetter($userId);
            }
        }

        $updaterSetter = 'set' . $blameable->getUpdater();

        // Test to store the object or the id/username
        if ($this->container->getParameter('pss.blameable.store_object')) {
            $entity->$updaterSetter($user ? $user : null);
        } else {
            $entity->$updaterSetter($userId);
        }
    }

}