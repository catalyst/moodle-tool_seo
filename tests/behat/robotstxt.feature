@tool @tool_seo
Feature: robots.txt is served from the configured setting
  In order to control how search engines crawl the site
  As an admin
  I need the configured robots.txt to be served at /robots.txt

  Scenario: The configured robots.txt content is served
    Given the following config values are set as admin:
      | robotstxt | User-agent: *Disallow: /private/ | tool_seo |
    When I visit "/robots.txt"
    Then I should see "User-agent: *"
    And I should see "Disallow: /private/"
