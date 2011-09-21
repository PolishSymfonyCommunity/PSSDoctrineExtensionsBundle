PSSDoctrineExtensionsBundle
========================

Installation
============

    1. Add to deps
    
        [PSSDoctrineExtensionsBundle]
            git=https://github.com/PolishSymfonySociety/PSSDoctrineExtensionsBundle.git
            target=/bundles/PSS/Bundle/DoctrineExtensionsBundle

    2. Add PSS namespace to autoloader
    
          // app/autoload.php
          $loader->registerNamespaces(array(
                'PSS' => __DIR__.'/../vendor/bundles',
                // your other namespaces
          ));

    3. Add PSSDoctrineExtensionsBundle to your application's kernel

          // app/AppKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new PSS\Bundle\DoctrineExtensionsBundle\PSSDoctrineExtensionsBundle(),
                  // ...
              );
          }

Configuration
=============

    # app/config/config.yml
        pss_doctrine_extensions:
          blameable:
            user_class: Acme\DemoBundle\Entity\User # your User class
            drivers:
              orm: true
              mongodb: true


Usage
=============

ORM example:

        <?php

        namespace Acme\DemoBundle\Entity;

        use Doctrine\ORM\Mapping as ORM;
        use PSS\Bundle\DoctrineExtensionsBundle\Annotation as PSS;

        /**
         * 
         * @ORM\Entity
         * @ORM\Table
         * 
         * @PSS\Blameable()
         */
        class Page
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             * 
             * @var integer $id
             */
            protected $id;

            /**
             * @ORM\Column(name="content", type="string", length=255, nullable=true)
             * 
             * @var string $name
             */
            protected $content;

            /**
             * @ORM\Column(type="integer", nullable=true)
             * 
             * @var type $creator
             */
            protected $creator;

            /**
             * @ORM\Column(type="integer", nullable=true)
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


ODM example with custom userClass, creator, updater property:

        <?php

        namespace Acme\DemoBundle\Document;

        use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
        use PSS\Bundle\DoctrineExtensionsBundle\Annotation as PSS;

        /**
         * @MongoDB\Document
         * 
         * @PSS\Blameable(userClass="Acme\DemoBundle\Document\User", creator="creator_id", updater="updater_id")
         */
        class Page
        {
            /**
             * @MongoDB\Id
             */
            protected $id;

            /**
             * @MongoDB\String
             */
            protected $content;

            /**
             * @MongoDB\Int
             * 
             * @var type $creator_id
             */
            protected $creator_id;

            /**
             * @MongoDB\Int
             * 
             * @var type $updater_id
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