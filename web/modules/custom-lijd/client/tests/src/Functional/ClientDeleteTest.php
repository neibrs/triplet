<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Core\Url;

/**
 * Simple test for client delete.
 *
 * @group client
 */
class ClientDeleteTest extends ClientTestBase {

  /**
   * Tests client delete.
   */
  public function testDelete() {
    $client = $this->createClient();

    $user = $this->drupalCreateUser([
      'delete client',
      'edit client',
      'view published client',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.client.edit_form', [
      'client' => $client->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Delete'));

    $this->clickLink(t('Delete'));
    $assert_session->statusCodeEquals(200);

    $this->drupalPostForm(NULL, [], t('Delete'));
    $assert_session->responseContains(t('The @entity-type %label has been deleted.', [
      '@entity-type' => t('client'),
      '%label' => $client->label(),
    ]));
  }

}
