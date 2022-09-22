<?php

namespace Drupal\client_url\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'client_url' formatter.
 *
 * @FieldFormatter(
 *   id = "client_url_formatter",
 *   label = @Translation("Client URL Formatter"),
 *   field_types = {
 *     "client_url"
 *   }
 * )
 */
class ClientURLFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the Client URL.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $urls = [];
    $client_urls = \Drupal::service('client_url.basic')->getClientURLs();
    foreach ($items as $delta => $item) {
      $values = $item->getValue();
      $counts = array_count_values($values);
      // Render each element as markup.
      foreach ($values as $key => $value) {
        if ($value == 1) {
          $url = $client_urls[$key];
          if ($counts[1] == count($client_urls)) {
            preg_match('/[a-z0-9][a-z0-9\-]{0,63}\.[a-z]{2,6}(\.[a-z]{1,2})?$/i', $url, $match);
            if (!in_array($match[0], $urls)) {
              $urls[] = $match[0];
              $element[] = ['#markup' => $match[0]];
            }
          }
          else {
            $element[] = ['#markup' => $url];
          }
        }
      }
    }

    return $element;
  }

}
