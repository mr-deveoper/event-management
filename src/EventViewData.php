<?php

namespace Drupal\event;

use Drupal\views\EntityViewsData;

/**
 * Render controller for events.
 */
class EventViewData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    return $data;
  }

}
