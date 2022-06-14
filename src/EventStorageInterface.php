<?php

namespace Drupal\event;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Defines a common interface for event entity controller classes.
 */
interface EventStorageInterface extends EntityStorageInterface {

  /**
   * Get the Latest Events posted on the site.
   *
   * @return mixed
   */
  public function getMostRecentEvent(ConfigFactoryInterface $config);

  /**
   * Find all duplicates of a event by matching the title.
   *
   * @param EventInterface $event
   *
   * @return mixed
   */
  public function getEventDuplicates(EventInterface $event);



}
