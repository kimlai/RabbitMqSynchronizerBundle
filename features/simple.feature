Feature: rabbitmq synchronization

    Scenario:
        Given There is a Producer named "old_sound_rabbit_mq.test_producer"
        And There is a Consumer named "old_sound_rabbit_mq.test_consumer" consuming from "test.topic"
        When The Producer "old_sound_rabbit_mq.test_producer" publishes a message with body "toto" on "test.topic"
        Then The Consumer "old_sound_rabbit_mq.test_consumer" has been called once with message "toto"
