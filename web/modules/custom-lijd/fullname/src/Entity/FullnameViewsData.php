<?php

namespace Drupal\fullname\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Fullname entities.
 */
class FullnameViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
