<?php
namespace App\Controllers;

use App\Services\Xml;

class HomeController
{
  public function index(): void
  {
    // 1. Cargar feeds
    $feeds = require BASE_PATH . '/app/config/feeds.php';

    // 2. Leer propiedades
    $properties = Xml::properties($feeds);

    // 3. Variables SEO básicas
    $title = 'Resales Costa Blanca';
    $description = 'Propiedades en venta en la Costa Blanca';

    // 4. Render con layout
    ob_start();
    require VIEW_PATH . '/home.php';
    $content = ob_get_clean();

    require VIEW_PATH . '/layout/layout.php';
  }
}
