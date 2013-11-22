<?php

namespace Lrqdo\Bundle\RabbitMqSynchronizerBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class AMQPMessageEvent extends Event
{
    /**
     * @var $message
     */
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
