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
                        ->canBeUnset()
                        ->children()
                            ->scalarNode('user_class')->isRequired()->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder->buildTree();
    }

}
