<?php
namespace App\Services;

class PropertyFilter
{
    public static function apply(array $properties, array $filters): array
    {
        return array_values(array_filter($properties, function ($p) use ($filters) {

            /* ================= PRICE ================= */

            if (!empty($filters['price_min']) && ($p['price'] ?? 0) < (int) $filters['price_min']) {
                return false;
            }

            if (!empty($filters['price_max']) && ($p['price'] ?? 0) > (int) $filters['price_max']) {
                return false;
            }


            /* ================= BATHS ================= */

            if (!empty($filters['baths']) && ($p['details']['baths'] ?? 0) < (int) $filters['baths']) {
                return false;
            }


            /* ================= TYPE ================= */

            if (!empty($filters['type']) && !in_array($p['type'] ?? '', (array) $filters['type'])) {
                return false;
            }


            /* ================= TOWN ================= */

            if (
                !empty($filters['town']) &&
                !in_array($p['location']['town'] ?? '', (array) $filters['town'])
            ) {
                return false;
            }


            /* ================= PROVINCE ================= */

            if (
                !empty($filters['province']) &&
                !in_array($p['location']['province'] ?? '', (array) $filters['province'])
            ) {
                return false;
            }


            /* ================= STATUS ================= */

            if (
                !empty($filters['status']) &&
                !in_array($p['status'] ?? '', (array) $filters['status'])
            ) {
                return false;
            }


            /* ================= FEATURES ================= */

            if (!empty($filters['features'])) {
                $match = array_intersect(
                    (array) $filters['features'],
                    $p['features'] ?? []
                );

                if (empty($match)) {
                    return false;
                }
            }

            return true;
        }));
    }
}
