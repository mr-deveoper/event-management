<?php

namespace Drupal\event\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\event\EventInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Defines the event entity class.
 *
 * @ContentEntityType(
 *   id = "event",
 *   label = @Translation("Event"),
 *   handlers = {
 *     "access" = "\Drupal\event\EventAccessControlHandler",
 *     "storage" = "Drupal\event\EventStorage",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *     "list_builder" = "Drupal\event\EventListBuilder",
 *     "view_builder" = "Drupal\event\EventViewBuilder",
 *     "views_data" = "Drupal\event\EventViewData",
 *     "form" = {
 *       "default" = "Drupal\event\Form\EventForm",
 *       "edit" = "Drupal\event\Form\EventForm",
 *       "delete" = "Drupal\event\Form\EventDeleteForm",
 *       "delete_items" = "Drupal\event\Form\EventItemsDeleteForm",
 *     }
 *   },
 *   links = {
 *     "canonical" = "/event/{event}",
 *     "edit-form" = "/event/{event}/edit",
 *     "delete-form" = "/event/{event}/delete"
 *   },
 *   base_table = "event",
 *   data_table = "event_field_data",
 *   admin_permission = "administer events",
 *   field_ui_base_route = "event.settings",
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode"
 *   }
 * )
 */

class Event extends ContentEntityBase implements EventInterface {


  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreated($created) {
    $this->set('created', $created);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getContent() {
    return $this->get('content')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreated() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getStartDate() {
    return $this->get('start_date')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setStartDate($date) {
    $this->set('start_date', $date);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
   public function getEndDate() {
    return $this->get('end_date')->value;
  }

  /**
   * {@inheritdoc}
   */
   public function setEndDate($date) {
    $this->set('end_date', $date);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
   public function getCity() {
    return $this->get('city')->value;
  }

  /**
   * {@inheritdoc}
   */
   public function setCity($city) {
    $this->set('city', $city);
    return $this;
  }



  /**
   * {@inheritdoc}
   */
   public function getCountry() {
    return $this->get('country')->value;
  }

  /**
   * {@inheritdoc}
   */
   public function setCountry($country) {
    $this->set('country', $country);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static  function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['id'] = BaseFieldDefinition::create('integer')
    ->setLabel(t('Event ID'))
    ->setDescription(t('The ID of the event.'))
    ->setReadOnly(TRUE)
    ->setSetting('unsigned', TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
    ->setLabel(t('UUID'))
    ->setDescription(t('The event UUID.'))
    ->setReadOnly(TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
    ->setLabel(t('Title'))
    ->setDescription(t('The event title.'))
    ->setRequired(TRUE)
    ->setTranslatable(TRUE)
    ->setSetting('max_length', 255)
    ->setDisplayOptions('form', array(
      'type' => 'string_textfield',
      'weight' => 1,
    ))
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);

    $fields['image'] = BaseFieldDefinition::create('image')
  ->setLabel(t('Image'))
  ->setDescription(t('Image field'))
  ->setSettings([
    'file_directory' => 'IMAGE_FOLDER',
    'alt_field_required' => FALSE,
    'file_extensions' => 'png jpg jpeg',
  ])
 ->setDisplayOptions('view', array(
    'label' => 'hidden',
    'type' => 'default',
    'weight' => 2,
  ))
  ->setDisplayOptions('form', array(
    'label' => 'hidden',
    'type' => 'image_image',
    'weight' => 2,
  ))
  ->setDisplayConfigurable('form', TRUE)
  ->setDisplayConfigurable('view', TRUE);

    $fields['text_long'] = BaseFieldDefinition::create('text_long')
    ->setLabel(t('Description'))
    ->setDescription(t('Main description of the event.'))
    ->setDisplayOptions('view', [
      'label' => 'visible',
      'type' => 'text_default',
      'weight' => 2,
    ])
    ->setDisplayOptions('form', [
      'type' => 'text_textarea',
      'weight' => 2,
      'rows' => 6,
    ])
    ->setDisplayConfigurable('view', TRUE)
    ->setDisplayConfigurable('form', TRUE);


    $fields['event_category'] = BaseFieldDefinition::create('entity_reference')
    ->setLabel(t('Category'))
    ->setDescription(t('The event category.'))
    ->setSetting('target_type', 'taxonomy_term')
    ->setSetting('handler_settings',
      [
        'target_bundles' =>
        [
          'taxonomy_term' => 'event_category'
        ]
      ]
    )
    ->setDisplayOptions('view', array(
      'label' => 'above',
      'type' => 'taxonomy_term',
    ))
    ->setDefaultValue(NULL)
    ->setDisplayOptions('form', [
      'type' => 'options_select',
      'settings' => [
        'match_operator' => 'CONTAINS',
        'size' => 60,
        'placeholder' => '',
      ],
      'weight' => 7,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);



    $fields['start_date'] = BaseFieldDefinition::create('datetime')
    ->setLabel(t('Start Date'))
    ->setDescription(t('Event start date.'))
    ->setRevisionable(TRUE)
    ->setRequired(TRUE)
    ->setSettings([
      'datetime_type' => 'date'
    ])
    ->setDefaultValue('')
    ->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'datetime_default',
      'settings' => [
        'format_type' => 'medium',
      ],
      'weight' => 10,
    ])
    ->setDisplayOptions('form', [
      'type' => 'datetime_default',
      'weight' => 10,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);



    $fields['end_date'] = BaseFieldDefinition::create('datetime')
    ->setLabel(t('End Date'))
    ->setDescription(t('Event end date.'))
    ->setRevisionable(TRUE)
    ->setSettings([
      'datetime_type' => 'date'
    ])
    ->setRequired(TRUE)
    ->setDefaultValue('')
    ->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'datetime_default',
      'settings' => [
        'format_type' => 'medium',
      ],
      'weight' => 10,
    ])
    ->setDisplayOptions('form', [
      'type' => 'datetime_default',
      'weight' => 10,
    ])
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);


    $fields['country'] = BaseFieldDefinition::create('string')
    ->setLabel(t('Country'))
    ->setDescription(t('The event country.'))
    ->setTranslatable(TRUE)
    ->setSetting('max_length', 255)
    ->setDisplayOptions('form', array(
      'type' => 'string_textfield',
      'weight' => 11,
    ))
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);


    $fields['city'] = BaseFieldDefinition::create('string')
    ->setLabel(t('City'))
    ->setDescription(t('The event city.'))
    ->setTranslatable(TRUE)
    ->setSetting('max_length', 255)
    ->setDisplayOptions('form', array(
      'type' => 'string_textfield',
      'weight' => 12,
    ))
    ->setDisplayConfigurable('form', TRUE)
    ->setDisplayConfigurable('view', TRUE);


    $fields['langcode'] = BaseFieldDefinition::create('language')
    ->setLabel(t('Language code'))
    ->setDescription(t('The event language code.'));

    $fields['created'] = BaseFieldDefinition::create('created')
    ->setLabel(t('Created'))
    ->setDescription(t('When the event was created, as a Unix timestamp.'));

    return $fields;
  }

  /**
   * Default value callback for 'uid' base field definition.
   *
   * @see ::baseFieldDefinitions()
   *
   * @return array
   *   An array of default values.
   */
  public static function getCurrentUserId() {
    return array(\Drupal::currentUser()->id());
  }

  /**
   *
   * {@inheritdoc}
   */
  public static function sort($a, $b) {
    return strcmp($a->label(), $b->label());
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);

    // codes here
  }
}
