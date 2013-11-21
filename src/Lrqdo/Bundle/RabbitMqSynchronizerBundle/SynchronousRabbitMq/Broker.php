<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq;

use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Event\AMQPMessageEvent;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Listener\AMQPMessageListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Broker
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function registerConsumer(Consumer $consumer)
    {
        foreach ($consumer->getQueueOptions()['routing_keys'] as $routingKey) {
            $this->dispatcher->addListener(
                $routingKey,
                array(
                    new AMQPMessageListener($consumer, $routingKey),
                    'execute',
                )
            );
        }
    }

    public function notifyConsumers($routingKey, AMQPMessageEvent $event)
    {
        $this->dispatcher->dispatch($routingKey, $event);
    }
}
