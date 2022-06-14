<?php

/**
 * @file
 * Contains \Drupal\config\ConfigSubscriberBase.
 */

namespace Drupal\event\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Config subscriber.
 */
abstract class ConfigLogSubscriberBase implements EventSubscriberInterface {
  /**
   * The Config.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory services.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Returns whether the config_name is ignored.
   *
   * @param string $config_name
   *   The config name variable.
   *
   * @return bool
   *   Config is ignored.
   */
  public function isIgnored($config_name) {
    if ($config_name == 'event_settings.settings') {
          return FALSE;
    }
    return TRUE;
  }

}
