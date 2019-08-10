<?php

namespace Drupal\fullname;

use Drupal\fullname\Entity\FullnameInterface;

interface NameProviderInterface {

  /**
   * Check name for Language-specific.
   * @return boolean
   */
  public function checkName(FullnameInterface $fullname);

}