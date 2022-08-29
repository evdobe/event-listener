@valid
Feature: ValidMessage
    In order to make an event available to a service
    I should be able to insert the event data into event database table

@unfiltered @untranslated
Scenario: Insert a valid message from an unfilterred and untranslated channel
    Given The channel is set
    When listener encounters an valid message 
    Then it should insert it in db

@corellation_id
Scenario: Insert a valid message from an unfilterred and untranslated channel with correlation id
    Given The channel is set
    When listener encounters an valid message with correlation id
    Then it should insert it in db with correlation id

@user_id
Scenario: Insert a valid message from an unfilterred and untranslated channel with user id
    Given The channel is set
    When listener encounters an valid message with user id
    Then it should insert it in db with user id
