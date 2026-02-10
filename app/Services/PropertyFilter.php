<?php
namespace App\Services;

class PropertyFilter
{
    public static function apply(array $properties, array $filters): array
    {
        return array_values(array_filter($properties, function ($p) use ($filters) {

            // Precio mínimo
            if (!empty($filters['price_min']) && $p['price'] < (int)$filters['price_min']) {
                return false;
            }

            // Precio máximo
            if (!empty($filters['price_max']) && $p['price'] > (int)$filters['price_max']) {
                return false;
            }

            // Baños
            if (!empty($filters['baths']) && $p['baths'] < (int)$filters['baths']) {
                return false;
            }

            // Tipo (array)
            if (!empty($filters['type']) && !in_array($p['type'], (array)$filters['type'])) {
                return false;
            }

            // Ciudad
            if (!empty($filters['town']) && !in_array($p['town'], (array)$filters['town'])) {
                return false;
            }

            // Provincia
            if (!empty($filters['province']) && !in_array($p['province'], (array)$filters['province'])) {
                return false;
            }

            // Estado
            if (!empty($filters['status']) && !in_array($p['status'] ?? '', (array)$filters['status'])) {
                return false;
            }

            // Features (al menos una coincidente)
            if (!empty($filters['features'])) {
                $match = array_intersect($filters['features'], $p['features'] ?? []);
                if (empty($match)) return false;
            }

            return true;
        }));
    }
}
