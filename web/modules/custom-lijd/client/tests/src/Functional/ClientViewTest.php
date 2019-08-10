<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for list.
 *
 * @group client
 */
class ClientViewTest extends ClientTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests canonical page.
   */
  public function testCanonical() {
    $this->drupalPlaceBlock('page_title_block');

    $client = $this->createClient();

    $user = $this->drupalCreateUser(['view published client']);
    $this->drupalLogin($user);

    $this->drupalGet(Url::fromRoute('entity.client.canonical', ['client' => $client->id()]));
    $this->assertResponse(200);
    $this->assertText($client->label());
  }

}
