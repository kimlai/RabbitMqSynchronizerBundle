<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq;

use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Event\AMQPMessageEvent;

class Producer extends \OldSound\RabbitMqBundle\RabbitMq\Producer
{
    /**
     * @var Broker
     */
    private $broker;

    public function setBroker(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function publish($msgBody, $routingKey = '', $additionalProperties = [])
    {
        $this->broker->notifyConsumers($routingKey, new AMQPMessageEvent($msgBody));
    }
}
