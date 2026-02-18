<?php
namespace App\Controllers;

use App\Services\PropertyFilter;
use App\Services\Xml;
use App\Services\GeoNormalizer;

class AjaxController
{
    public function towns(): void
    {
        header('Content-Type: application/json');

        $provinces = (array) ($_GET['province'] ?? []);

        $properties = Xml::properties();

        $towns = [];

        foreach ($properties as $p) {

            $prov = GeoNormalizer::province($p['location']['province'] ?? null);
            $town = GeoNormalizer::town($p['location']['town'] ?? null);

            if (!$prov || !$town) {
                continue;
            }

            if (!empty($provinces) && !in_array($prov, $provinces)) {
                continue;
            }

            $towns[$town] = true;
        }

        $towns = array_keys($towns);
        sort($towns);

        echo json_encode($towns);
    }

    public function list(): void
    {
        $allProperties = Xml::properties();

        // filtros
        $properties = PropertyFilter::apply($allProperties, $_GET);

        // orden
        if (!empty($_GET['sort'])) {
            usort($properties, function ($a, $b) {
                return $_GET['sort'] === 'price_asc'
                    ? $a['price'] <=> $b['price']
                    : $b['price'] <=> $a['price'];
            });
        }

        // paginación
        $perPage = 20;
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $total = count($properties);
        $totalPages = (int) ceil($total / $perPage);

        $properties = array_slice($properties, ($page - 1) * $perPage, $perPage);

        // devolver SOLO el HTML parcial
        require VIEW_PATH . '/partials/properties-grid.php';
    }

}
