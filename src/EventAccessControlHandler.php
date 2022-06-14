<?php

namespace Drupal\event;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines an access control handler for the event entity.
 *
 * @see \Drupal\event\Entity\Event
 */
class EventAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create events', 'administer events'], 'OR');
  }

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    // Allow view access if the user has the access events permission.
    if ($operation == 'view') {
      return AccessResult::allowedIfHasPermission($account, 'access events');
    }
    elseif ($operation == 'update' ) {
      return AccessResult::allowedIfHasPermissions($account, [
        'edit events',
        'administer events',
      ], 'OR');
    }
    // Otherwise fall back to the parent which checks the administer events
    // permission.
    return parent::checkAccess($entity, $operation, $account);
  }

  /**
   * {@inheritdoc}
   */
  protected function checkFieldAccess($operation, FieldDefinitionInterface $field_definition, AccountInterface $account, FieldItemListInterface $items = NULL) {

    if ($operation === 'edit') {
      return AccessResult::allowedIfHasPermission($account, 'administer events');
    }
    return parent::checkFieldAccess($operation, $field_definition, $account, $items);
  }
}
