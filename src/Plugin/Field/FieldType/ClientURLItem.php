<?php

namespace Drupal\client_url\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'client_url' field type.
 *
 * @FieldType(
 *   id = "client_url",
 *   label = @Translation("Client URL"),
 *   description = @Translation("This field stores client URL from a text file."),
 *   category = @Translation("Text"),
 *   default_widget = "client_url_widget",
 *   default_formatter = "client_url_formatter",
 * )
 */
class ClientURLItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $client_urls = \Drupal::service('client_url.basic')->getClientURLs();
    foreach ($client_urls as $key => $client_url) {
      $properties[$key] = DataDefinition::create('boolean')
        ->setLabel($client_url);
    }

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    // Make a column for every URL.
    $client_urls = \Drupal::service('client_url.basic')->getClientURLs();
    foreach ($client_urls as $key => $client_url) {
      $output['columns'][$key] = array(
        'type' => 'int',
        'length' => 1,
      );
    }

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {

    $item = $this->getValue();

    $has_url = FALSE;

    // See if any of the url checkboxes have been checked off.
    $client_urls = \Drupal::service('client_url.basic')->getClientURLs();
    foreach ($client_urls as $key => $client_url) {
      if (isset($item[$key]) && $item[$key] == 1) {
        $has_url = TRUE;
        break;
      }
    }

    return !$has_url;
  }

}
