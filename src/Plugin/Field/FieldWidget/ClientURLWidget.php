<?php

namespace Drupal\client_url\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'client_url' widget.
 *
 * @FieldWidget(
 *   id = "client_url_widget",
 *   module = "client_url",
 *   label = @Translation("Client URL widget"),
 *   field_types = {
 *     "client_url"
 *   }
 * )
 */
class ClientURLWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'checkboxes',
      '#default_value' => $value,
      '#options' => [
        '1'  => 'url_1',
        '2' => 'url_2',
      ],
    ];
    return ['value' => $element];
  }

}