<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;
use Drupal\client\Entity\ClientType;

/**
 * Simple test for client_type list.
 *
 * @group client
 */
class ClientTypeListTest extends ClientTestBase {

  public function testList() {
    $client_type = ClientType::load('wechat');

    $user = $this->drupalCreateUser([
      'administer client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.client_type.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains($client_type->label());
  }

}
