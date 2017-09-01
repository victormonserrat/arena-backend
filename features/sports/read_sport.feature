@sports
  Feature: Read sport.
    In order to see in detail an available sport
    As a person interested in practicing sport
    I want to show it.

  Scenario: Show available sport logged.
    Given the sport Tennis
    And the user user
    And this user is logged
    When he wants to show this sport
    Then he sees this sport

  Scenario: Show not available sport logged.
    Given the user user
    And this user is logged
    When he wants to show an unknown sport
    Then he sees that could not be found

  Scenario: Show available sport not logged.
    Given the sport Tennis
    When someone wants to show this sport
    Then he sees this sport

  Scenario: Show not available sport not logged.
    When someone wants to show an unknown sport
    Then he sees that could not be found