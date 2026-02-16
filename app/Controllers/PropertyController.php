<?php
namespace App\Controllers;

use App\Services\TextNormalizer;
use App\Services\Xml;

class PropertyController
{
    public function show(string $id): void
    {
        /* =====================================================
           1. Obtener propiedades
        ===================================================== */
        $properties = Xml::properties();


        /* =====================================================
           2. Buscar propiedad por ID
        ===================================================== */
        $property = $this->findProperty($properties, $id);

        /* =====================================================
           3. 404 si no existe
        ===================================================== */
        if (!$property) {
            http_response_code(404);
            echo 'Propiedad no encontrada';
            return;
        }

        // $property = $this->normalizeProperty($property);


        /* =====================================================
           4. SEO dinámico
        ===================================================== */
        $seo = $this->buildSeo($property);


        /* =====================================================
           5. Render vista
        ===================================================== */
        ob_start();
        require VIEW_PATH . '/property/show.php';
        $content = ob_get_clean();

        require VIEW_PATH . '/layout/layout.php';
    }




    /* =====================================================
       Buscar propiedad
    ===================================================== */
    private function findProperty(array $properties, string $id): ?array
    {
        foreach ($properties as $p) {
            if (($p['id'] ?? null) === $id) {
                return $p;
            }
        }

        return null;
    }




    /* =====================================================
       SEO builder
    ===================================================== */
    private function buildSeo(array $property): array
    {
        $type = $property['type'] ?? 'Property';
        $town = $property['location']['town'] ?? 'Unknown';
        $price = number_format($property['price'] ?? 0, 0, ',', '.');

        return [
            'title' => "{$type} en {$town}",
            'description' => "Compra " . strtolower($type) . " en {$town} por {$price} €.",
        ];
    }

    private function normalizeProperty(array $property): array
    {
        foreach (['en', 'es'] as $lang) {
            if (!empty($property['desc'][$lang])) {
                $property['desc'][$lang] = TextNormalizer::description($property['desc'][$lang]);
            }
        }

        return $property;
    }

}
