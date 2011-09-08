<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Annotation;

use Symfony\Component\DependencyInjection;

/**
 * Blameable.
 * 
 * @Annotation
 * 
 */
class Blameable implements DependencyInjection\ContainerAwareInterface
{
    /**
     * @var string $userClass
     */
    private $userClass = null;

    /**
     * @var string $creator
     */
    private $creator = 'creator';

    /**
     * @var string $updator
     */
    private $updater = 'updater';

    /**
     * @var DI Container $container
     */
    private $container;

    public function setContainer(DependencyInjection\ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Gets the "userClass" option.
     * 
     * @return string The "userClass" option
     */
    public function getUserClass()
    {
        return $this->userClass;
    }

    /**
     * Sets the "updater" option.
     * 
     * @param type $value The "userClass" option
     */
    public function setUserClass($value)
    {
        $this->userClass = $value;
    }

    /**
     * Gets the "updater" option.
     * 
     * @return string The "updater" option
     */
    public function getUpdater()
    {
        return $this->updater;
    }

    /**
     * Sets the "updater" option.
     * 
     * @param type $value The "updater" option
     */
    public function setUpdater($value)
    {
        $this->updater = $value;
    }

    /**
     * Gets the "creator" option.
     * 
     * @return string The "creator" option
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Sets the "creator" option.
     * 
     * @param type $value The "creator" option
     */
    public function setCreator($value)
    {
        $this->creator = $value;
    }

    /**
     * Constructs a new instance of Blameable.
     * 
     * @param array $values The option values
     */
    public function __construct(array $values)
    {
        if (isset($values['userClass'])) {
            if (class_exists($values['userClass'])) {
                $refClass = new \ReflectionClass($values['userClass']);
                if ($refClass->newInstance() instanceof \Symfony\Component\Security\Core\User\UserInterface) {
                    $this->userClass = $values['userClass'];
                } else {
                    throw new \InvalidArgumentException('User class must implement \Symfony\Component\Security\Core\User\UserInterface');
                }
            }
        } else {
            if ($this->container->has('pss.blameable.user_class')) {
                $this->userClass = get('pss.blameable.user_class');
            } else {
                throw new \InvalidArgumentException('You must define a "userClass" attribute or "user_class" config.');
            }
        }
        if (isset($values['creator'])) {
            $this->creator = $values['creator'];
        }
        if (isset($values['updater'])) {
            $this->updater = $values['updater'];
        }
    }

}