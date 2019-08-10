<?php

namespace Drupal\consultant;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Consultant entity.
 *
 * @see \Drupal\consultant\Entity\Consultant.
 */
class ConsultantAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\consultant\Entity\ConsultantInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished consultant entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published consultant entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit consultant entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete consultant entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add consultant entities');
  }

}
