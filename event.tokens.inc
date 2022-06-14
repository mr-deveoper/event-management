<?php

/**
 * @file
 * Builds placeholder replacement tokens for values specific to Event nodes.
 */

use Drupal\Core\Render\BubbleableMetadata;

/**
 * Implements hook_token_info().
 */
function event_token_info() {
  $node['duration'] = array(
    'name' => t("Event duration"),
    'description' => t("The length of time the event is set to run."),
  );

  return array(
    'tokens' => array('event' => $node),
  );
}

/**
 * Implements hook_tokens().
 */
function event_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
  $replacements = array();

  if ($type == 'event' && !empty($data['event'])) {
    /** @var \Drupal\event\Entity\Event $event */
    $event = $data['event'];

    foreach ($tokens as $name => $original) {
      switch ($name) {

        case 'duration':
        $replacements[$original] = \Drupal::service('date.formatter')->formatInterval($event->getRuntime());
        break;
      }
    }
  }

  return $replacements;
}
