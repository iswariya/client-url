<?php

namespace Drupal\client_url\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ModuleExtensionList;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to read client URLs from text file.
 */
class ClientURLController extends ControllerBase {

  /**
   * Module Extension List.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $moduleExtensionList;

  /**
   * ClientURLController constructor.
   *
   * @param \Drupal\Core\Extension\ModuleExtensionList $module_extension_list
   *   The form builder.
   */
  public function __construct(ModuleExtensionList $module_extension_list) {
    $this->moduleExtensionList = $module_extension_list;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extension.list.module')
    );
  }

  public function getClientURLs() {
    $module_path = $this->moduleExtensionList->getPath('client_url');
    if (file_exists($module_path .'/files/client_urls.txt')) {
      $client_urls = explode("\n", file_get_contents($module_path .'/files/client_urls.txt'));
    }
    $output = [];
    foreach ($client_urls as $client_url) {
      $key = str_replace('.', '_', $client_url);
      $output[$key] = $client_url;
    }
    return $output;
  }
}