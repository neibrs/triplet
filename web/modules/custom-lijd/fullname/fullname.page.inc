<?php

/**
 * @file
 * Contains fullname.page.inc.
 *
 * Page callback for Fullname entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Fullname templates.
 *
 * Default template: fullname.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_fullname(array &$variables) {
  // Fetch Fullname Entity Object.
  $fullname = $variables['elements']['#fullname'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
