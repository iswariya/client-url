<?php

namespace Drupal\client_url\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldFilteredMarkup;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'client_url_item' field type.
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
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Client URL value'))
      ->addConstraint('Length', ['max' => 255])
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
      'indexes' => [
        'value' => ['value'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

}
