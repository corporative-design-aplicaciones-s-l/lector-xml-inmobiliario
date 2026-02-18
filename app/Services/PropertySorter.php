<?php
namespace App\Services;

class PropertySorter
{
    public static function apply(array $properties, ?string $sort): array
    {
        if (!$sort) {
            return $properties;
        }

        usort($properties, function ($a, $b) use ($sort) {

            return match ($sort) {

                'price_asc' => ($a['price'] ?? 0) <=> ($b['price'] ?? 0),

                'price_desc' => ($b['price'] ?? 0) <=> ($a['price'] ?? 0),

                'newest' => strtotime($b['created_at'] ?? '0')
                <=> strtotime($a['created_at'] ?? '0'),

                default => 0,
            };
        });

        return $properties;
    }
}
