Feature:

  Scenario: Easy task for mk1
    When I request "/automaton/mk1/change/2" using HTTP GET
    Then the response code is 200
    And the response content is equal to:
      """
      {
          "bill10": 0,
          "bill5": 0,
          "coin2": 0,
          "coin1": 2
      }
      """

  Scenario: Easy task for mk2
    When I request "/automaton/mk2/change/2" using HTTP GET
    Then the response code is 200
    And the response content is equal to:
      """
      {
          "bill10": 0,
          "bill5": 0,
          "coin2": 1,
          "coin1": 0
      }
      """

  Scenario: Impossible task for mk2
    When I request "/automaton/mk2/change/3" using HTTP GET
    Then the response code is 204
    And the response content is empty

  Scenario: Unknown model
    When I request "/automaton/mk3/change/2" using HTTP GET
    Then the response code is 404
