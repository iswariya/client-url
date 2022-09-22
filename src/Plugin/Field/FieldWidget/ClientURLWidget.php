<?php

namespace Drupal\client_url\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\WidgetInterface;
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
class ClientURLWidget extends WidgetBase implements WidgetInterface {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // $item is where the current saved values are stored.
    $item =& $items[$delta];

    $element['client_urls'] = [
      '#title' => t('Client URLs'),
      '#type' => 'fieldset',
      '#process' => array(__CLASS__ . '::processURLsFieldset'),
    ];

    // Create a checkbox item for each URL.
    $client_urls = \Drupal::service('client_url.basic')->getClientURLs();
    foreach ($client_urls as $key => $client_url) {
      $element['client_urls'][$key] = [
        '#title' => t($client_url),
        '#type' => 'checkbox',
        '#default_value' => isset($item->$key) ? $item->$key : '',
      ];
    }

    return $element;
  }

  /**
   * Form widget process callback.
   */
  public static function processURLsFieldset($element, FormStateInterface $form_state, array $form) {

    // The last fragment of the name, i.e. meat|toppings is not required
    // for structuring of values.
    $elem_key = array_pop($element['#parents']);

    return $element;

  }
}
