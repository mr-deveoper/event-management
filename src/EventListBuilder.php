<?php

/**
 * Contains \Drupal\event\EventListBuilder.
 */

namespace Drupal\event;

use Drupal;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Config\Entity\DraggableListBuilder;

/**
 * Defines a class to build a listing of user role entities.
 *
 * @see \Drupal\user\Entity\Role
 */
class EventListBuilder extends DraggableListBuilder {

  /**
   * {@inheritdoc}
   */
  public function load() {
    $entities = $this->storage->loadMultiple();
    // Sort the entities using the entity class's sort() method.
    // See \Drupal\Core\Config\Entity\ConfigEntityBase::sort().
    uasort($entities, array($this->entityType->getClass(), 'sort'));
    return $entities;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_list_form';
  }

  /**
   * Overrides Drupal\Core\Entity\EntityListController::buildHeader().
   */
  public function buildHeader() {

    $header['title'] = t('Title');
    $header['start_date'] = t('Start Date');
    $header['end_date'] = t('End Date');
    $header['created'] = t('Created');
    $header['operations'] = t('Operations');
    return $header + parent::buildHeader();
  }

  /**
   * Overrides Drupal\Core\Entity\EntityListController::buildRow().
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = $entity->toLink()->toString();
    $row['start_date'] = $entity->getStartDate();
    $row['end_date'] = $entity->getEndDate();
    $row['created'] = ($entity->getCreated()) ? Drupal::service('date.formatter')
    ->format($entity->getCreated(), 'long') : t('n/a');
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getOperations(EntityInterface $entity) {
    $operations = parent::getOperations($entity);

    return $operations;
  }

}
