<?php
namespace App\Controllers;

use App\Services\PropertySorter;
use App\Services\TypeNormalizer;
use App\Services\Xml;
use App\Services\PropertyFilter;
use App\Services\GeoNormalizer;

class HomeController
{
  public function index(): void
  {
    /* =====================================================
       1. CARGAR TODAS LAS PROPIEDADES (desde XML/cache)
    ===================================================== */
    $allProperties = Xml::properties();


    /* =====================================================
       2. NORMALIZACIÓN DEFENSIVA GEO + TYPE
    ===================================================== */
    foreach ($allProperties as &$p) {

      // GEO
      $p['location']['province'] = GeoNormalizer::province($p['location']['province'] ?? null);
      $p['location']['town'] = GeoNormalizer::town($p['location']['town'] ?? null);

      // TYPE
      $p['type'] = TypeNormalizer::type($p['type'] ?? null);
    }
    unset($p);


    /* =====================================================
       3. MAPA PROVINCIA → CIUDADES (SIN FILTRAR)
    ===================================================== */
    $provinceMap = [];

    foreach ($allProperties as $p) {

      $prov = $p['location']['province'] ?? null;
      $town = $p['location']['town'] ?? null;

      if (!$prov || !$town) {
        continue;
      }

      $provinceMap[$prov][$town] = true;
    }

    // Ordenar ciudades dentro de cada provincia
    foreach ($provinceMap as $prov => $towns) {
      ksort($towns);
      $provinceMap[$prov] = array_keys($towns);
    }

    ksort($provinceMap);


    /* =====================================================
       4. LISTAS BASE DE FILTROS (SIN FILTRAR)
    ===================================================== */

    // Tipos únicos
    $types = array_unique(array_column($allProperties, 'type'));
    sort($types);

    // Provincias
    $provinces = array_keys($provinceMap);

    // Features únicas (ya normalizadas)
    $features = [];
    foreach ($allProperties as $p) {
      foreach ($p['features'] ?? [] as $f) {
        $features[$f] = true;
      }
    }
    $features = array_keys($features);
    sort($features);


    /* =====================================================
       5. CIUDADES SEGÚN PROVINCIA SELECCIONADA
    ===================================================== */
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

      // Todas las ciudades si no hay provincia seleccionada
      $towns = [];

      foreach ($provinceMap as $provTowns) {
        foreach ($provTowns as $t) {
          $towns[$t] = true;
        }
      }

      $towns = array_keys($towns);
      sort($towns);
    }

    // 5. Aplicar filtros
    $filtered = PropertyFilter::apply($allProperties, $_GET);

    // 5.1 Ordenar resultados
    $properties = PropertySorter::apply(
      $filtered,
      $_GET['sort'] ?? null
    );


    /* =====================================================
       7. PAGINACIÓN
    ===================================================== */
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $perPage = 20;

    $total = count($filtered);
    $totalPages = (int) ceil($total / $perPage);

    $offset = ($page - 1) * $perPage;

    $properties = array_slice($filtered, $offset, $perPage);


    /* =====================================================
       8. SEO BÁSICO
    ===================================================== */
    $title = 'Resales Costa Blanca';
    $description = 'Propiedades en venta en la Costa Blanca';


    /* =====================================================
       9. RENDER
    ===================================================== */
    ob_start();
    require VIEW_PATH . '/home.php';
    $content = ob_get_clean();

    require VIEW_PATH . '/layout/layout.php';
  }
}
