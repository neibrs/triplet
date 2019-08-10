<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for client_type add.
 *
 * @group client
 */
class ClientTypeAddTest extends ClientTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests add form.
   */
  public function testAddForm() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'administer client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.client_type.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add'));

    $this->clickLink(t('Add'));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'id' => strtolower($this->randomMachineName()),
      'label' => $this->randomMachineName(),
    ];
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $assert_session->statusCodeEquals(200);
    $assert_session->responseContains(t('Created the %label Client type.', [
      '%label' => $edit['label'],
    ]));
  }

}
