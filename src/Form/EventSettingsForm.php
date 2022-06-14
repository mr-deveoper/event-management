<?php

namespace Drupal\event\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for event settings.
 */
class EventSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_settings';
  }

  /**
   * {@inheritdoc}
   */
   protected function getEditableConfigNames() {
    return [
      'event_settings.settings',
    ];
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // This exists to make the field UI pages visible and must not be removed.
    $config = $this->config('event_settings.settings');
    $form['past'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide Past Events'),
      '#name' => 'past',
      '#default_value' =>(boolean) $config->get('past'),
    ];


    $form['pages'] = [
      '#type' => 'textfield',
      '#title' => $this->t('number of events to list on the listing page'),
      '#step' => 1,
      '#attributes' => array(
        ' type' => 'number',
        ' min' => '0',
      ),
      '#size' => 64,
      '#required' => true,
      '#default_value' => $config->get('pages'),
    ];

    return parent::buildForm($form, $form_state);
  }


  /**
   * {@inheritdoc}
   */
   public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

    /**
   * {@inheritdoc}
   */
   public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('event_settings.settings')
      ->set('past', $form_state->getValue('past'))
      ->set('pages', $form_state->getValue('pages'))
      ->save();
  }

}

