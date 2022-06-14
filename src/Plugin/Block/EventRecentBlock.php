<?php

namespace Drupal\event\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a 'Latest Events' block.
 *
 * @Block(
 *   id = "event_recent_block",
 *   admin_label = @Translation("Latest Events"),
 *   category = @Translation("Lists (Views)")
 * )
 */
class EventRecentBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
   protected $configFactory;
  /**
   * Drupal\Core\Config\ImmutableConfig.
   *
   * @var \\Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Construct a new EventRecentBlock object.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct($configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager,ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->configFactory = $config_factory;
    $this->config = $this->configFactory->get('event_settings.settings');

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access events');
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return array('event_list');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $events = $this->entityTypeManager->getStorage('event')->getMostRecentEvent($this->config);

    foreach ($events as $event) {
      $build[] = $this->entityTypeManager->getViewBuilder('event')->view($event, 'block');
    }

    $results = array(
      '#markup' => render($build),  // Raw HTML code in  $output
    );

    $results[] = array(
      '#type' => 'pager',
    );

    return $results;

  }

}
