<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable;

use Doctrine\Common\Annotations\Reader;
use PSS\Bundle\DoctrineExtensionsBundle\Driver\Blameable\AnnotationDriver;
use PSS\Bundle\DoctrineExtensionsBundle\Listener\ORM\BlameableListener;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ORMTest extends WebTestCase
{
    protected $reader;
    protected $annotationDriver;
    protected $blameableAnnotation;
    protected $blameableEnity;
    protected $blameableEnityNonStandard;
    protected $nonBlameableEntity;
    protected $ormListener;
    protected $lifecycleArgs;

    protected function setUp()
    {
        $client = static::createClient(array(), array(
                    'PHP_AUTH_USER' => 'user',
                    'PHP_AUTH_PW' => 'userpass',
                ));
        $this->annotationDriver = $this->getMockBuilder('PSS\Bundle\DoctrineExtensionsBundle\Driver\Blameable\AnnotationDriver')->disableOriginalConstructor()->getMock();
        $this->blameableAnnotation = $this->getMockBuilder('PSS\Bundle\DoctrineExtensionsBundle\Annotation\Blameable')->disableOriginalConstructor()->getMock();
        $this->blameableEnity = $this->getMock('PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity\Blameable');
        $this->blameableEnityNonStandard = $this->getMock('PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity\BlameableNonStandard');
        $this->nonBlameableEntity = $this->getMock('PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity\NonBlameable');
        $this->ormListener = new BlameableListener();
        $this->ormListener->setContainer($client->getContainer());
        $this->ormListener->setDriver($this->annotationDriver);
        $this->lifecycleArgs = $this->getMockBuilder('Doctrine\ORM\Event\LifecycleEventArgs')->disableOriginalConstructor()->getMock();
    }

    public function testStandardBlameableEntity()
    {
        $this->lifecycleArgs
                ->expects($this->once())
                ->method('getEntity')
                ->will($this->returnValue($this->blameableAnnotation));

        $this->blameableAnnotation
                ->expects($this->once())
                ->method('getUpdater')
                ->will($this->returnValue('updater'));

        $this->blameableAnnotation
                ->expects($this->once())
                ->method('getCreator')
                ->will($this->returnValue('creator'));

        $this->annotationDriver
               ->expects($this->once())
               ->method('getBlameableAnnotation')
               ->will($this->returnValue($this->blameableAnnotation));
        

        $this->ormListener->prePersist($this->lifecycleArgs);

//        $this->assertEquals('user', $this->blameableEnity->getUpdater());
//        $this->assertEquals('user', $this->blameableEnity->getUpdater());
    }

    public function testBlameableEntityWithNonStandardOption()
    {
        
    }

    public function testNonBlameableEntity()
    {
        
    }

}