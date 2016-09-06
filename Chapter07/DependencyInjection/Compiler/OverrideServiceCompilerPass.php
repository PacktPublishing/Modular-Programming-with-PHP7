<?php

namespace Foggyline\CatalogBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Override the core module 'category_menu' service
        $container->removeDefinition('category_menu');
        $container->setDefinition('category_menu', $container->getDefinition('foggyline_catalog.category_menu'));

        // Override the core module 'onsale' service
        $container->removeDefinition('onsale');
        $container->setDefinition('onsale', $container->getDefinition('foggyline_catalog.onsale'));
    }
}