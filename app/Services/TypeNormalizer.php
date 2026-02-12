<?php

namespace App\Services;
class TypeNormalizer
{
    private static array $map = [

        // Villas
        'villa' => 'Villa',
        'villas' => 'Villa',

        // Townhouse
        'townhouse' => 'Townhouse',
        'town house' => 'Townhouse',
        'terraced house' => 'Townhouse',
        'terraced house townhouse' => 'Townhouse',
        'town house penthouse' => 'Townhouse',

        // Apartment
        'apartment' => 'Apartment',
        'apartamento' => 'Apartment',
        'apartment penthouse' => 'Apartment',
        'flat' => 'Apartment',

        // Penthouse
        'penthouse' => 'Penthouse',
        'penthouse penthouse' => 'Penthouse',

        // Bungalow
        'bungalow' => 'Bungalow',
        'bungalows' => 'Bungalow',
        'bungalow penthouse' => 'Bungalow',

        // Duplex
        'duplex' => 'Duplex',
        'duplex penthouse' => 'Duplex',


        // Finca / country house
        'finca' => 'Finca',
        'country house' => 'Finca',

        // Plot
        'plot' => 'Plot',
        'land' => 'Plot',

        // Commercial
        'commercial' => 'Commercial',
        'business premises' => 'Commercial',
        'commercial premises commercial unit retail space' => 'Commercial',

        // Quad house
        'quad house' => 'Quad House',
        'quad' => 'Quad House',
        'quadruplex' => 'Quad House',
        'quadruplex house' => 'Quad House',
        'quadruplex townhouse' => 'Quad House',
        'quadruplex apartment' => 'Quad House',
        'quad house penthouse' => 'Quad House',
    
        // Semidetached 
        'semidetached' => 'Semidetached', 
        'semi detached' => 'Semidetached', 
        'semi-detached' => 'Semidetached', 
        'adosado' => 'Semidetached',
        'semi detached penthouse' => 'Semidetached',
           ];


    private static function clean(string $value): string
    {
        $v = mb_strtolower(trim($value));
        $v = preg_replace('/[^a-z\s]/', ' ', $v);
        $v = preg_replace('/\s+/', ' ', $v);

        return trim($v);
    }


    public static function type(?string $value): ?string
    {
        if (!$value)
            return null;

        $clean = self::clean($value);

        return self::$map[$clean] ?? ucfirst($clean);
    }
}
