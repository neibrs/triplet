<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for client_type delete.
 *
 * @group client
 */
class ClientTypeDeleteTest extends ClientTestBase {

  /**
   * Tests client_type delete.
   */
  public function testDelete() {
    // Prepare data
    $type_no_data = $this->createClientType();
    $type_has_data = $this->createClientType();
    $this->createClient([
      'type' => $type_has_data->id(),
    ]);

    $user = $this->drupalCreateUser([
      'administer client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    // Tests delete type with no data
    $this->drupalGet(Url::fromRoute('entity.client_type.edit_form', [
      'client_type' => $type_no_data->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Delete'));

    $this->clickLink(t('Delete'));
    $assert_session->statusCodeEquals(200);

    $this->drupalPostForm(NULL, [], t('Delete'));
    $assert_session->responseContains(t('The @entity-type %label has been deleted.', [
      '@entity-type' => t('client type'),
      '%label' => $type_no_data->label(),
    ]));
    // Tests delete type with data
    $this->drupalGet(Url::fromRoute('entity.client_type.delete_form', [
      'client_type' => $type_has_data->id(),
    ]));
    $assert_session->responseContains(t('You can not remove %type until you have removed all of the %type %entity.', [
      '%type' => $type_has_data->label(),
      '%entity' => t('Client'),
    ]));
  }

}
