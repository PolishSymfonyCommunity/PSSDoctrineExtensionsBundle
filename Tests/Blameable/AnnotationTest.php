<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable;

use Doctrine\Common\Annotations\Reader;
use PSS\Bundle\DoctrineExtensionsBundle\Driver\Blameable\AnnotationDriver;

class AnnotationTest extends \PHPUnit_Framework_TestCase
{
    protected $reader;
    protected $annotationDriver;
    protected $blameableAnnotation;
    protected $blameableEnity;
    protected $blameableEnityNonStandard;
    protected $nonBlameableEntity;

    protected function setUp()
    {
        $this->reader = $this->getMock('Doctrine\Common\Annotations\Reader');
        $this->annotationDriver = new AnnotationDriver($this->reader);
        $this->blameableAnnotation = $this->getMockBuilder('PSS\Bundle\DoctrineExtensionsBundle\Annotation\Blameable')->disableOriginalConstructor()->getMock();
        $this->blameableEnity = $this->getMock('PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity\Blameable');
        $this->blameableEnityNonStandard = $this->getMock('PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity\BlameableNonStandard');
        $this->nonBlameableEntity = $this->getMock('PSS\Bundle\DoctrineExtensionsBundle\Tests\Blameable\Entity\NonBlameable');
    }

    public function testStandardBlameableEntity()
    {
        $this->blameableAnnotation
                ->expects($this->once())
                ->method('getCreator')
                ->will($this->returnValue('creator'));

        $this->blameableAnnotation
                ->expects($this->once())
                ->method('getUpdater')
                ->will($this->returnValue('updater'));

        $this->reader
                ->expects($this->once())
                ->method('getClassAnnotation')
                ->with($this->isInstanceOf('\ReflectionClass'), $this->equalTo('PSS\Bundle\DoctrineExtensionsBundle\Annotation\Blameable'))
                ->will($this->returnValue($this->blameableAnnotation));

        $annot = $this->annotationDriver->getBlameableAnnotation($this->blameableEnity);

        $this->assertNotNull($annot);
        $this->assertEquals('creator', $annot->getCreator());
        $this->assertEquals('updater', $annot->getUpdater());
    }
    
    public function testBlameableEntityWithNonStandardOption()
    {
        $this->blameableAnnotation
                ->expects($this->once())
                ->method('getCreator')
                ->will($this->returnValue('creator_id'));

        $this->blameableAnnotation
                ->expects($this->once())
                ->method('getUpdater')
                ->will($this->returnValue('updater_id'));

        $this->reader
                ->expects($this->once())
                ->method('getClassAnnotation')
                ->with($this->isInstanceOf('\ReflectionClass'), $this->equalTo('PSS\Bundle\DoctrineExtensionsBundle\Annotation\Blameable'))
                ->will($this->returnValue($this->blameableAnnotation));

        $annot = $this->annotationDriver->getBlameableAnnotation($this->blameableEnity);

        $this->assertNotNull($annot);
        $this->assertEquals('creator_id', $annot->getCreator());
        $this->assertEquals('updater_id', $annot->getUpdater());
    }

    public function testNonBlameableEntity()
    {
        $annot = $this->annotationDriver->getBlameableAnnotation($this->nonBlameableEntity);

        $this->assertNull($annot);
    }

}