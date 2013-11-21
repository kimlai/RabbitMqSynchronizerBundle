<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq;

use Lrqdo\Bundle\RabbitMqSynchronizerBundle\Event\AmqMessageEvent;

class Producer extends \OldSound\RabbitMqBundle\RabbitMq\Producer
{
    /**
     * @var SynchronousBroker
     */
    private $broker;

    public function setSynchronousRabbitMqServer(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function publish($msgBody, $routingKey = '')
    {
        echo "----------- PUBLISH !! " . $routingKey . " ----------------\n";
        echo "msgBody " . $msgBody . " ----------------\n";
        $this->broker->start();
        $this->broker->getDispatcher()->dispatch($routingKey, new AmqMessageEvent($msgBody));
    }
}
