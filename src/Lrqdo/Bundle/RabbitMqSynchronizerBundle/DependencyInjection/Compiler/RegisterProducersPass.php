<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RegisterProducersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lrqdo.rabbitmq_synchronizer.broker')) {
            return;
        }

        foreach ($container->findTaggedServiceIds('old_sound_rabbit_mq.producer') as $id => $attributes) {
            $definition = $container->getDefinition($id);
            $definition->setClass('Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq\Producer');
            $definition->addMethodCall(
                'setBroker',
                array(new Reference('lrqdo.rabbitmq_synchronizer.broker'))
            );
        }
    }
}
