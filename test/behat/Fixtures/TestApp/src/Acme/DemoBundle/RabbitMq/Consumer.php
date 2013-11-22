<?php

namespace Acme\DemoBundle\RabbitMq;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer implements ConsumerInterface
{
    private $executeCalls;

    public function __construct()
    {
        $this->executeCalls = array();
    }

    public function execute(AMQPMessage $message)
    {
        $this->executeCalls[] = $message;
    }

    public function getExecuteCalls()
    {
        return $this->executeCalls;
    }
}
