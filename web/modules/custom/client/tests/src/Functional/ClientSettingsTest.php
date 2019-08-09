<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for client settings.
 *
 * @group client
 */
class ClientSettingsTest extends ClientTestBase {

  /**
   * Tests client settings.
   */
  public function testClientSettings() {
    $user = $this->drupalCreateUser([
      'administer client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('client.settings'));
    $assert_session->statusCodeEquals(200);
  }

}
