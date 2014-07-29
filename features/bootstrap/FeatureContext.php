<?php

use Hamcrest\MatcherAssert as ha,
    Hamcrest\Matchers as hm;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;

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
        
        ha::assertThat(
            $producer,
            hm::is(hm::anInstanceOf(
                $this
                    ->getContainer()
                    ->getParameter('old_sound_rabbit_mq.producer.class')
            ))
        );
    }

    /**
     * @Given /^There is a Consumer named "([^"]*)" consuming from "([^"]*)"$/
     */
    public function thereIsAConsumerNamed($name, $topic)
    {
        $consumer = $this->getContainer()->get($name);

        ha::assertThat(
            $consumer,
            hm::is(hm::anInstanceOf(
                $this
                    ->getContainer()
                    ->getParameter('old_sound_rabbit_mq.consumer.class')
            ))
        );

        ha::assertThat(
            $consumer->getQueueOptions()['routing_keys'],
            hm::is(hm::arrayContaining($topic))
        );
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

        ha::assertThat(count($consumerCalls), hm::is(hm::identicalTo(1)));
        ha::assertThat($message, hm::is(hm::identicalTo($consumerCalls[0]->body)));
    }
}
