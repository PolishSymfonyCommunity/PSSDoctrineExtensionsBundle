<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class PSSDoctrineExtensionsExtension extends Extension
{
    private $listenerTag = array(
        'orm' => 'doctrine.event_subscriber',
        'mongodb' => 'doctrine.common.event_subscriber'
    );

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('blameable.xml');

        $config = $processor->process($configuration->getConfigTree(), $configs);
        if (isset($config['blameable']['user_class'])) {
            if (class_exists($config['blameable']['user_class'])) {
                $refClass = new \ReflectionClass($config['blameable']['user_class']);
                if ($refClass->newInstance() instanceof \Symfony\Component\Security\Core\User\UserInterface) {
                    $container->setParameter('pss.blameable.user_class', $config['blameable']['user_class']);
                } else {
                    throw new \InvalidArgumentException('User class must implements \Symfony\Component\Security\Core\User\UserInterface');
                }
            } else {
                throw new \InvalidArgumentException('Class doesn\'t exist.');
            }
        }
        if (isset($config['blameable']['store_object'])) {
            $container->setParameter('pss.blameable.store_object', $config['blameable']['store_object']);
        } else {
            $container->setParameter('pss.blameable.store_object', $config['blameable']['store_object']);
        }

        foreach ($config['blameable']['drivers'] as $name => $enable) {
            if ($enable) {
                if (isset($this->listenerTag[$name])) {
                    $container->getDefinition('pss.blameable.listener.'. $name)->addTag($this->listenerTag[$name]);
                } else {
                    throw new \InvalidArgumentException(printf('%s DB driver is not supported', $name));
                }
            }
        }
    }

}