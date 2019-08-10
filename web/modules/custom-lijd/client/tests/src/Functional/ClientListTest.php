<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for client list.
 *
 * @group client
 */
class ClientListTest extends ClientTestBase {

  /**
   * Tests client list.
   */
  public function testList() {
    $client = $this->createClient();

    $user = $this->drupalCreateUser([
      'view published client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.client.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists($client->label());
  }

}
