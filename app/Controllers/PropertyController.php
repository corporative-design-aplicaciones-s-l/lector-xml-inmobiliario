<?php
namespace App\Controllers;

use App\Services\Xml;

class PropertyController
{
    public function show(string $id): void
    {
        // =====================================================
        // 1. Cargar todas las propiedades desde cache
        // =====================================================
        $properties = Xml::properties();


        // =====================================================
        // 2. Buscar propiedad por ID
        // =====================================================
        $property = null;

        foreach ($properties as $p) {
            if (($p['id'] ?? null) === $id) {
                $property = $p;
                break;
            }
        }


        // =====================================================
        // 3. 404 si no existe
        // =====================================================
        if (!$property) {
            http_response_code(404);
            echo 'Propiedad no encontrada';
            return;
        }


        // =====================================================
        // 4. SEO básico dinámico
        // =====================================================
        $title = ($property['type'] ?? 'Propiedad')
            . ' en '
            . ($property['town'] ?? 'Costa Blanca');

        $description = 'Compra '
            . strtolower($property['type'] ?? 'propiedad')
            . ' en '
            . ($property['town'] ?? 'Costa Blanca')
            . ' por '
            . number_format($property['price'] ?? 0, 0, ',', '.')
            . ' €.';


        // =====================================================
        // 5. Render vista show
        // =====================================================
        ob_start();
        require VIEW_PATH . '/property/show.php';
        $content = ob_get_clean();

        require VIEW_PATH . '/layout/layout.php';
    }
}
