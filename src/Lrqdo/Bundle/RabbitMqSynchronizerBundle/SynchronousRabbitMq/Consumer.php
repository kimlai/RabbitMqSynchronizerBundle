<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\SynchronousRabbitMq;

class Consumer extends \OldSound\RabbitMqBundle\RabbitMq\Consumer
{
    public function getQueueOptions()
    {
        return $this->queueOptions;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
