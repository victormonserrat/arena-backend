@sports
  Feature: Read sports.
    In order to see the available sports
    As a person interested in practicing sport
    I want to show them.

  Scenario: Show available sports logged.
    Given the sports:
      | Name    |
      | Tennis  |
      | Golf    |
    And the user user
    And this user is logged
    When he wants to show the available sports
    Then he sees 2

  Scenario: Search available sport logged.
    Given the sports:
      | Name    |
      | Tennis  |
      | Golf    |
    And the user user
    And this user is logged
    When he searches sports by golf
    Then he sees 1

  Scenario: Search not available sport logged.
    Given the user user
    And this user is logged
    When he searches sports by soccer
    Then he sees 0

  Scenario: Show available sports not logged.
    Given the sports:
      | Name    |
      | Tennis  |
      | Golf    |
    When someone wants to show the available sports
    Then he sees 2

  Scenario: Search available sport not logged.
    Given the sports:
      | Name    |
      | Tennis  |
      | Golf    |
    When someone searches sports by golf
    Then he sees 1

  Scenario: Search not available sport not logged.
    When someone searches sports by soccer
    Then he sees 0