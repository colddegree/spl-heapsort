Feature: Integer list sorting
  In order to develop software
  As an list library user
  I need to be able to sort list of integers

  Definition 1: |L| ∈ ℕ
  Definition 2: L_i ∈ ℤ
  Definition 3: sorted(L) ⇔ ∀L |L| > 0, ∀L_i, L_(i+1): L_(i+1) >= L_i
  Corollary 1: |L| = |sorted(L)|

  Scenario: Sorting an empty list
    Given list
    |  |
    When I sort it
    Then I should have list
    |  |

  Scenario: Sorting list with only 1 element
    Given list
    | 1 |
    When I sort it
    Then I should have list
    | 1 |

  Scenario: Sorting list with only same elements
    Given list
    | 1 | 1 |
    When I sort it
    Then I should have list
    | 1 | 1 |

  Scenario: Sorting list with 2 distinct elements
    Given list
    | 2 | 1 |
    When I sort it
    Then I should have list
    | 1 | 2 |

  Scenario: Sorting list with doubles
    Given list
      | 2 | 1 | 2 | 1 | 3 |
    When I sort it
    Then I should have list
      | 1 | 1 | 2 | 2 | 3 |

  Scenario: Sorting heterogeneous list
    Given list
    | 42 | foo |
    When I instantiate it from strings
    Then I should receive an exception
