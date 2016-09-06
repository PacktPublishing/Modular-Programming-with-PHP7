<?php

namespace Foggyline\CatalogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('foggyline_catalog');

//        $rootNode
//            ->children()
//                ->arrayNode('uploads_directory')
//                    ->children()
//                        ->scalarNode('category_images')
//                            ->defaultValue('%kernel.root_dir%/../web/uploads/category_images')
//                        ->end()
//                        ->scalarNode('product_images')
//                            ->defaultValue('%kernel.root_dir%/../web/uploads/product_images')
//                        ->end()
//                    ->end()
//                ->end()
//            ->end();

        return $treeBuilder;
    }
}
