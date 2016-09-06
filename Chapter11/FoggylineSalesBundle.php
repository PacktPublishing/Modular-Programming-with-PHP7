<?php

namespace Foggyline\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Foggyline\SalesBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;

class FoggylineSalesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);;
        $container->addCompilerPass(new OverrideServiceCompilerPass());
    }
}
