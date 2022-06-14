<?php

namespace Drupal\event;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining an event entity.
 */
interface EventInterface extends ContentEntityInterface {

  /**
   * Sets the title for the event.
   *
   * @param string $title
   *   The short title of the feed.
   *
   * @return \Drupal\event\EventInterface
   *   The class instance that this method is called on.
   */
  public function setTitle($title);

  /**
   * Return when the feed was modified last time.
   *
   * @return int
   *   The timestamp of the last time the feed was modified.
   */
  public function getCreated();


  /**
   * Return Event Start Date.
   *
   * @return date
   */
   public function getStartDate();


  /**
   * Return Event End Date.
   *
   * @return date
   */
  public function getEndDate();


  /**
   * Sets the last modification of the feed.
   *
   * @param int $created
   *   The timestamp when the feed was modified.
   *
   * @return \Drupal\event\EventInterface
   *   The class instance that this method is called on.
   */
  public function setCreated($created);


}
