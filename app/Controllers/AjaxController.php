<?php
namespace App\Controllers;

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
}
