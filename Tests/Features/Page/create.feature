@mink:selenium2
Feature: Create a page

Background:
    Given I am logged in as "anakin@victoire.io"
     And I maximize the browser

Scenario: I can create a new page
    Given I should see "Page"
    Given I select the option "Nouvelle page" in the dropdown "Page"
    And I should see "Créer"
    And I fill in "Nom" with "tatooine"
    Then I submit the widget
    And I should see "Victoire"
    And I wait 10 seconds
    And I should be on "/fr/tatooine"

Scenario: I can change name and Then the url should match "<pattern>"
    Given I am on "/fr/tatooine"
    And I select the option "Paramètres de la page" in the dropdown "Page"
    And I should see "Mettre à jour"
    Then I fill in "Nom" with "anoth"
    Then I fill in "victoire_page_settings_type_slug" with "anoth"
    And I submit the widget
    And I should see "Victoire"
    And I wait 10 seconds
    And I should be on "/fr/anoth"

