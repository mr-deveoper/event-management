<?php

namespace Drupal\event;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;

/**
 * Controller class for events.
 *
 * This extends the default content entity storage class,
 * adding required special handling for event entities.
 */
class EventStorage extends SqlContentEntityStorage implements EventStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function getEventDuplicates(EventInterface $event) {
    $query = \Drupal::entityQuery('event');
    $query->condition('title', $event->label());

    if ($event->id()) {
      $query->condition('id', $event->id(), '<>');
    }
    return $this->loadMultiple($query->execute());
  }

  /**
   * {@inheritdoc}
   */
  public function getMostRecentEvent($config) {

    $query = \Drupal::entityQuery('event');
    if($config->get('past'))
    {
      $query = $query->condition('end_date', date('Y-m-d'),'>');
    }
    $query = $query->sort('created', 'DESC')->range(0,5);
    return $this->loadMultiple($query->execute());
  }
}
