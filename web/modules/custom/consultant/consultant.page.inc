<?php

/**
 * @file
 * Contains consultant.page.inc.
 *
 * Page callback for Consultant entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Consultant templates.
 *
 * Default template: consultant.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_consultant(array &$variables) {
  // Fetch Consultant Entity Object.
  $consultant = $variables['elements']['#consultant'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
