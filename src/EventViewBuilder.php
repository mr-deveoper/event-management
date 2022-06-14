<?php

namespace Drupal\event;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * Render controller for events.
 */
class EventViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'full', $langcode = NULL) {
    $entity = $this->entityRepository->getTranslationFromContext($entity, $langcode);

    // Ajax request might send the view mode as a GET argument, use that
    // instead.
    if (\Drupal::request()->query->has('view_mode')) {
      $view_mode = \Drupal::request()->query->get('view_mode');
    }

    $output = parent::view($entity, $view_mode, $langcode);
    $output['#theme_wrappers'] = array('container');
    $output['#attributes']['class'][] = 'event-view';
    $output['#attributes']['class'][] = $view_mode;

    $output['#event'] = $entity;

    return $output;

  }

}
