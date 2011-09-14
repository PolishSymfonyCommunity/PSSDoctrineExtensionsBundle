<?php

namespace PSS\Bundle\DoctrineExtensionsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle
 *
 */
class Configuration
{

    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pss_doctrine_extensions');

        $rootNode
                ->children()
                    ->arrayNode('blameable')
                        ->children()
                            ->scalarNode('user_class')->end()
                            ->arrayNode('drivers')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('orm')->defaultValue(true)->end()
                                    ->booleanNode('mongodb')->defaultValue(false)->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder->buildTree();
    }
    
}
