<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\Listener;

use PhpAmqpLib\Message\AMQPMessage;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Event\AMQPMessageEvent;
use Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq\Consumer;

class AMQPMessageListener
{
    /**
     * @var Consumer
     */
    private $consumer;

    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function execute(AMQPMessageEvent $event)
    {
        call_user_func($this->consumer->getCallback(), new AMQPMessage($event->getMessage()));
    }
}
