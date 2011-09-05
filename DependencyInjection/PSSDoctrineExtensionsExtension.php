<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class PSSDoctrineExtensionsExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->process($configuration->getConfigTree(), $configs);
        if (isset($config['blameable'])) {
            if (class_exists($config['blameable']['user_class'])) {
                $refClass = new \ReflectionClass($config['blameable']['user_class']);
                if ($refClass->newInstance() instanceof \Symfony\Component\Security\Core\User\UserInterface) {
                    $container->setParameter('pss.blameable.user_class', $config['blameable']['user_class']);
                }
            } else {
                throw new \InvalidArgumentException(printf('Class %s doesn\'t exist.', $config['blameable']['user_class']));
            }
        }

//        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    }

}