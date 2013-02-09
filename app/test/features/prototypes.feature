Feature: multiprototypes
    As a prototype editor
    I can easily run multiple prototype on a same prontotype instance
    In order to access useful functionalities

Scenario: match prototypes on domain and base_url
    Given I am on "http://prontotype-bar.lo"
    Then the "h1" element should contain "Test Prototype BAR"
    Given I am on "http://prontotype-foo.lo"
    Then the "h1" element should contain "Test Prototype FOO"
    Given I am on "http://prontotype-bar.lo/foo"
    Then the "h1" element should contain "Test Prototype FOO"
    Given I am on "http://prontotype-bar.lo/foo"
    Then the "h1" element should contain "Test Prototype FOO"
    Given I am on "http://prontotype-bar.lo/foo/navigation"
    Then the "h1" element should contain "menu"
    Given I am on "http://prontotype-bar.lo/foo/navigation"
    Then the "h1" element should contain "menu"

Scenario: page-links take base_url into account
    Given I am on "http://prontotype-foo.lo/navigation"
    Then the "#page-link" element should contain "/sub/yet"
    And the "#page-link" element should not contain "/foo/sub/yet"
    Given I am on "http://prontotype-bar.lo/foo/navigation"
    Then the "#page-link" element should contain "/foo/sub/yet"
