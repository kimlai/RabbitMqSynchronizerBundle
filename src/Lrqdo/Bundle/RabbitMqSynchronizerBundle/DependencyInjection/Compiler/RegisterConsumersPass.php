<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RegisterConsumersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lrqdo.rabbitmq_synchronizer.broker')) {
            return;
        }

        $definition = $container->getDefinition('lrqdo.rabbitmq_synchronizer.broker');

        foreach ($container->findTaggedServiceIds('old_sound_rabbit_mq.consumer') as $id => $attributes) {
            $consumerDefinition = $container->getDefinition($id);
            $consumerDefinition->setClass('Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq\Consumer');
            $definition->addMethodCall(
                'registerConsumer',
                array(new Reference($id))
            );
        }
    }
}
