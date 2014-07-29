<?php

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    use KernelDictionary;

    /**
     * @Given /^There is a Producer named "([^"]*)"$/
     */
    public function thereIsAProducerNamed($name)
    {
        $producer = $this->getContainer()->get($name);
        
        assertInstanceOf(
            $this->getContainer()->getParameter('old_sound_rabbit_mq.producer.class'),
            $producer
        );
    }

    /**
     * @Given /^There is a Consumer named "([^"]*)" consuming from "([^"]*)"$/
     */
    public function thereIsAConsumerNamed($name, $topic)
    {
        $consumer = $this->getContainer()->get($name);
        
        assertInstanceOf(
            $this->getContainer()->getParameter('old_sound_rabbit_mq.consumer.class'),
            $consumer
        );

        assertTrue(in_array(
            $topic,
            $consumer->getQueueOptions()['routing_keys']
        ));
    }

    /**
    * @When /^The Producer "([^"]*)" publishes a message with body "([^"]*)" on "([^"]*)"$/
    */
    public function theProducerPublishesAMessageWithBodyOn($producerId, $msgBody, $topic)
    {
        $this
            ->getContainer()
            ->get($producerId)
            ->publish($msgBody, $topic);
    }

    /**
     * @Then /^The Consumer "([^"]*)" has been called once with message "([^"]*)"$/
     */
    public function theConsumerHasBeenCalledOnceWithMessage($consumerId, $message)
    {
        $consumerCalls = $this
            ->getContainer()
            ->get($consumerId)
            ->getCallback()[0]
            ->getExecuteCalls();

        assertEquals(1, count($consumerCalls));
        assertEquals($consumerCalls[0]->body, $message);
    }
}
