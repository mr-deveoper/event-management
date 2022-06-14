<?php

namespace Drupal\event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\event\EventInterface;

/**
 * Returns responses for event module routes.
 */
class EventController extends ControllerBase {

  /**
   * Route title callback.
   *
   * @param \Drupal\event\EventInterface $event
   *   The event entity.
   *
   * @return string
   *   The event label.
   */
  public function eventTitle(EventInterface $event) {
    return $event->label();
  }

}
