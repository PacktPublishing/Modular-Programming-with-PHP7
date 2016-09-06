<?php

namespace Foggyline\CustomerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Foggyline\CustomerBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;

class FoggylineCustomerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);;
        $container->addCompilerPass(new OverrideServiceCompilerPass());
    }
}
