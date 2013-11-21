<?php

$loader = require(__DIR__.'/../../../../../vendor/autoload.php');
$loader->add('Lrqdo\\Bundle\\RabbitMqSynchronizerBundle', __DIR__.'/../../../src');
$loader->add('Acme\\DemoBundle', __DIR__.'/../src');

return $loader;
