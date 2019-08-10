<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for client add.
 *
 * @group client
 */
class ClientAddTest extends ClientTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests client add.
   */
  public function testAdd() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'add client',
      'view published client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.client.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add'));

    $this->clickLink(t('Add'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Wechat'));

    $this->clickLink(t('Wechat'));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'name[0][value]' => $this->randomString(10),
    ];
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $this->assertResponse(200);
    $this->assertRaw(t('Created the %label Client.', ['%label' => $edit['name[0][value]']]));
  }

}
