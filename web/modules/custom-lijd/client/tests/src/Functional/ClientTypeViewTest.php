<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;
use Drupal\client\Entity\ClientType;

/**
 * Simple test for list.
 *
 * @group client
 */
class ClientTypeViewTest extends ClientTestBase {

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

    // Prepare data for test
    $client_type = ClientType::load('wechat');
    $wechat_client = $this->createClient(['type' => 'wechat']);
    $platform_client = $this->createClient(['type' => 'platform']);

    $user = $this->drupalCreateUser([
      'administer client',
      'view published client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.client_type.canonical', [
      'client_type' => $client_type->id(),
    ]));

    // TODO
    $assert_session->statusCodeEquals(200);
    // Tests the page title
    $assert_session->responseContains($client_type->label());
    // Tests the client list
    $assert_session->linkExists($wechat_client->label());
    $assert_session->linkNotExists($platform_client->label());
  }

}
