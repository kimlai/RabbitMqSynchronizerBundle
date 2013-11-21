<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Listener\AmqMessageListener;

class Broker
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var listeners
     */
    private $listeners;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->listeners = array();
    }

    public function registerSynchronousConsumer(Consumer $consumer)
    {
        foreach ($consumer->getQueueOptions()['routing_keys'] as $routingKey) {
            $this->listeners[$routingKey] = new AmqMessageListener($consumer, $routingKey);
        }
    }

    public function start()
    {
        foreach ($this->listeners as $event => $listener) {
            $this->dispatcher->addListener(
                $event,
                array($listener, 'execute')
            );     
        }
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}
