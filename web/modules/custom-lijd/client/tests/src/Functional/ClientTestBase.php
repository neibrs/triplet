<?php

namespace Drupal\Tests\client\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\client\Traits\ConsultantTestTrait;

class ClientTestBase extends BrowserTestBase {

  use ConsultantTestTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['client'];

  /**
   * @var \Drupal\client\Entity\ClientInterface
   */
  protected $client;
  
  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->client = $this->createClient();
  }

}
