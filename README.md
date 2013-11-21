# RabbitMqSychronizerBundle

## About ##

When using asynchronous messaging system such as [RabbitMQ](http://www.rabbitmq.com/), it's rather difficult to use functional tests to see if your messages are correctly published and consumed, and test the overall behaviour of your application.

This bundle tranforms the RabbitMq broker provided by the [RabbitMqBundle](https://github.com/videlalvaro/RabbitMqBundle) into a Symfony2 synchronous event dispatcher, thus enabling easy testing, using functional test frameworks (such as [Behat](http://behat.org/)).

## Installation ##

Require the bundle in you composer.json file :

````
{
    require-dev: {
        "kimlai/rabbitmq-synchronizer-bundle": "*@dev"
    }
}
````
  
Register the bundle :

````php
//app/AppKernel.php

public function registerBundles()
{
    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        $bundles[] = new Lrqdo\Bundle\RabbitMqSynchronizerBundle\LrqdoRabbitMqSynchronizerBundle();
    }
}
````

Install the bundle :
````
$ php composer.phar update kimlai/rabbitmq-synchronizer-bundle
````

## Usage ##

You don't need to change anything in you rabbitmq config, you can keep using Producers and Consumers just like you did before.

When you're running you app in the __dev__ or __test__ environment, the bundle will create a new service named `lrqdo.rabbitmq-synchronizer.broker`. This is the service that replaces the actual RabbitMQ broker.

Then it looks for all services with the tags `old_sound_rabbit_mq.producer` or `old_sound_rabbit_mq.consumer`, and replaces them with custom instances, providing all the necesary plumbing so that the app behaves exactly like it did before, only in a synchronous way.

Once this is done, when your producers publish messages on a topic, the consumers are executed synchronously from within Symfony, just like any EventListener.
