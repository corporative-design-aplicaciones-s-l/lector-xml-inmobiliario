<?php
namespace App\Controllers;

use App\Services\Xml;
use App\Services\PropertyFilter;
use App\Services\GeoNormalizer;

class HomeController
{
  public function index(): void
  {
    // =====================================================
    // 1. CARGAR TODAS LAS PROPIEDADES (cache local)
    // =====================================================
    $allProperties = Xml::properties();


    // =====================================================
    // 2. NORMALIZACIÓN DEFENSIVA GEO (importante)
    // =====================================================
    foreach ($allProperties as &$p) {
      $p['province'] = GeoNormalizer::province($p['province'] ?? null);
      $p['town'] = GeoNormalizer::town($p['town'] ?? null);
    }
    unset($p);


    // =====================================================
    // 3. CONSTRUIR MAPA PROVINCIA → CIUDADES (SIN FILTRAR)
    // =====================================================
    $provinceMap = [];

    foreach ($allProperties as $p) {

      $prov = $p['province'] ?? null;
      $town = $p['town'] ?? null;

      if (!$prov || !$town)
        continue;

      $provinceMap[$prov][$town] = true;
    }

    // Ordenar ciudades dentro de cada provincia
    foreach ($provinceMap as $prov => $towns) {
      ksort($towns);
      $provinceMap[$prov] = array_keys($towns);
    }

    ksort($provinceMap);


    // =====================================================
    // 4. LISTAS DE FILTROS BASE (SIN FILTRAR)
    // =====================================================
    $types = array_unique(array_column($allProperties, 'type'));
    sort($types);

    $provinces = array_keys($provinceMap);

    // Features únicas (ya normalizadas previamente)
    $features = [];
    foreach ($allProperties as $p) {
      foreach ($p['features'] ?? [] as $f) {
        $features[$f] = true;
      }
    }
    $features = array_keys($features);
    sort($features);


    // =====================================================
    // 5. CIUDADES SEGÚN PROVINCIA SELECCIONADA
    // =====================================================
    $selectedProvinces = (array) ($_GET['province'] ?? []);

    if (!empty($selectedProvinces)) {

      $towns = [];

      foreach ($selectedProvinces as $prov) {
        foreach ($provinceMap[$prov] ?? [] as $t) {
          $towns[$t] = true;
        }
      }

      $towns = array_keys($towns);
      sort($towns);

    } else {

      // todas las ciudades si no hay provincia seleccionada
      $towns = [];

      foreach ($provinceMap as $provTowns) {
        foreach ($provTowns as $t) {
          $towns[$t] = true;
        }
      }

      $towns = array_keys($towns);
      sort($towns);
    }

    // =====================================================
    // 6. APLICAR FILTROS → RESULTADOS VISIBLES
    // =====================================================
    $filtered = PropertyFilter::apply($allProperties, $_GET);


    // =====================================================
    // 7. PAGINACIÓN
    // =====================================================
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $perPage = 20;

    $total = count($filtered);
    $totalPages = (int) ceil($total / $perPage);

    $offset = ($page - 1) * $perPage;

    $properties = array_slice($filtered, $offset, $perPage);


    // =====================================================
    // 8. SEO BÁSICO
    // =====================================================
    $title = 'Resales Costa Blanca';
    $description = 'Propiedades en venta en la Costa Blanca';



    // =====================================================
    // 9. RENDER
    // =====================================================
    ob_start();
    require VIEW_PATH . '/home.php';
    $content = ob_get_clean();

    require VIEW_PATH . '/layout/layout.php';
  }
}
