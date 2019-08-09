<?php

namespace Drupal\Tests\consultant\Functional;

use Drupal\Core\Url;

/**
 * Simple test for consultant add.
 *
 * @group consultant
 */
class ConsultantAddTest extends ConsultantTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests consultant add.
   */
  public function testAdd() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'add consultant',
      'view published consultant',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.consultant.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Add'));

    $this->clickLink(t('Add'));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'name[0][value]' => $this->randomString(10),
    ];
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $this->assertResponse(200);
    $this->assertRaw(t('Created the %label Consultant.', ['%label' => $edit['name[0][value]']]));
  }

}
