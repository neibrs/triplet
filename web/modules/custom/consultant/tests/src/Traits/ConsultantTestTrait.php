<?php

namespace Drupal\Tests\consultant\Traits;

use Drupal\consultant\Entity\Consultant;

trait ConsultantTestTrait {

  /**
   * @param array $settings
   *   (optional) An associative array of settings for the consultant, as used in
   *   entity_create().
   *
   * @return \Drupal\consultant\Entity\ConsultantInterface
   *   The created consultant entity.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createConsultant(array $settings = []) {
    $settings += [
      'name' => $this->randomString(10),
    ];
    $entity = Consultant::create($settings);
    $entity->save();

    return $entity;
  }

}
