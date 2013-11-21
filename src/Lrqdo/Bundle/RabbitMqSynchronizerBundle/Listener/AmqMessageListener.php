<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\Listener;

use PhpAmqpLib\Message\AMQPMessage;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Event\AmqMessageEvent;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq\Consumer;

class AmqMessageListener
{
    /**
     * @var Consumer
     */
    private $consumer;

    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function execute(AmqMessageEvent $event)
    {
        $this->consumer->getCallback()[0]->execute(new AMQPMessage($event->getMessage()));
    }
}
