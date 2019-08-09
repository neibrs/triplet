<?php

namespace Drupal\Tests\client\Traits;

use Drupal\client\Entity\Client;
use Drupal\client\Entity\ClientType;

trait ClientTestTrait {

  /**
   * @param array $settings
   *   (optional) An associative array of settings for the client, as used in
   *   entity_create().
   *
   * @return \Drupal\client\Entity\ClientInterface
   *   The created client entity.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createClient(array $settings = []) {
    $settings += [
      'type' => 'wechat',
      'name' => $this->randomString(10),
    ];
    $entity = Client::create($settings);
    $entity->save();

    return $entity;
  }

  /**
   * @param array $settings
   *
   * @return \Drupal\client\Entity\ClientType
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createClientType(array $settings = []) {
    $settings += [
      'id' => $this->randomMachineName(),
    ];
    $entity = ClientType::create($settings);
    $entity->save();

    return $entity;
  }

}
