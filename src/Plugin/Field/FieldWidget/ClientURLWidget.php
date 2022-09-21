<?php

namespace Drupal\client_url\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\client_url\Controller\ClientURLController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Field\FieldDefinitionInterface;

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
class ClientURLWidget extends WidgetBase implements ContainerFactoryPluginInterface {

  /**
   * ClientURLController.
   *
   * @var \Drupal\client_url\Controller\ClientURLController
   */
  protected $clientURLController;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, ClientURLController $client_url_controller) {
    $this->clientURLController = $client_url_controller;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('client_url.basic')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // $item is where the current saved values are stored.
    $item =& $items[$delta];

    // $element is already populated with #title, #description, #delta,
    // #required, #field_parents, etc.
    //
    // In this example, $element is a fieldset, but it could be any element
    // type (textfield, checkbox, etc.)

    $element += array(
      '#type' => 'fieldset',
    );

    $element['client_urls'] = [
      '#title' => t('Client URLs'),
      '#type' => 'fieldset',
      '#process' => [
        $this->processURLsFieldset()
      ],
    ];

    // Create a checkbox item for each topping on the menu.
    $client_urls = $this->clientURLController->getClientURLs();
    foreach ($client_urls as $key => $client_url) {
      $element['client_urls'][$key] = array(
        '#title' => t($client_url),
        '#type' => 'checkbox',
        '#default_value' => isset($item->$key) ? $item->$key : '',
      );
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
