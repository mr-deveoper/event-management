<?php

namespace Drupal\event\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the event edit forms.
 */
class EventForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $event = $this->entity;

    if ($event->isNew()) {
      $title = $this->t('Add new event');
    }
    else {
      $title = $this->t('Edit @label', ['@label' => $event->label()]);
    }
    $form['#title'] = $title;

    $form['#attached'] = ['library' => ['event/admin']];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $event = $this->buildEntity($form, $form_state);
    // Check for duplicate titles.
    $event_storage = $this->entityTypeManager->getStorage('event');
    $result = $event_storage->getEventDuplicates($event);

    if($event->getStartDate() > $event->getEndDate()  )
    {
      $form_state->setErrorByName('end_date', $this->t('end date must not exceed the start date'));
    }

    foreach ($result as $item) {
      if (strcasecmp($item->label(), $event->label()) == 0) {
        $form_state->setErrorByName('title', $this->t('A feed named %feed already exists. Enter a unique title.', array('%feed' => $event->label())));
      }
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $event = $this->entity;
    $insert = (bool) $event->id();
    $event->save();
    if ($insert) {
      $this->messenger()->addMessage($this->t('The event %event has been updated.', array('%event' => $event->label())));
    }
    else {
      \Drupal::logger('event')->notice('Event %event added.', array('%event' => $event->label(), 'link' => $event->toLink()->toString()));
      $this->messenger()->addMessage($this->t('The event %event has been added.', array('%event' => $event->label())));
    }

    $form_state->setRedirect('event.event_list');
  }

}
