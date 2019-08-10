<?php

namespace Drupal\fullname;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\fullname\Entity\FullnameInterface;

class NameProvider implements NameProviderInterface {

  /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function checkName(FullnameInterface $fullname) {
    // Test chinese name.
    if ( preg_match("/\p{Han}+/u", $fullname->name->value)) {
      $string_fullname = \Drupal::transliteration()->transliterate($fullname->name->value);
      if (strtolower($fullname->last_name->value) . strtolower($fullname->first_name->value) === $string_fullname) {
        return TRUE;
      }
    }
    return FALSE;
  }
}
