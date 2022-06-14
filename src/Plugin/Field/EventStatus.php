<?php

namespace Drupal\event\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;


/**
 * Field handler which displays the flag indicating whether the event is active
 *
 * @ViewsField("event_status")
 */
class EventStatus extends FieldPluginBase {

  /**
   * @param \Drupal\views\ResultRow $values
   * @return mixed
   */
  function render(ResultRow $values) {
    /** @var \Drupal\event\EventInterface $entity */
    $entity = $values->_entity;

    if ($entity->getEndDate() < date('Y-m-d')) {
      $output = 'false';
    }
    else {
     $output = 'true';
    }

    return $output;
  }
}
