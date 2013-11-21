<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\DependencyInjection\Compiler\RegisterConsumersPass;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\DependencyInjection\Compiler\RegisterProducersPass;

class LrqdoRabbitMqSynchronizerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $container->addCompilerPass(new RegisterConsumersPass());
        $container->addCompilerPass(new RegisterProducersPass());
    }
}
