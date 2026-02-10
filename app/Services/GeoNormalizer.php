<?php
namespace App\Services;

class GeoNormalizer
{
    /**
     * Mapeo manual de provincias problemáticas
     */
    private static array $provinceMap = [

        // Alicante
        'alicante' => 'Alicante',
        'alicante costa blanca' => 'Alicante',
        'costa blanca alicante' => 'Alicante',
        'torrevieja' => 'Alicante',

        // Murcia
        'murcia' => 'Murcia',
        'murcia costa calida' => 'Murcia',

        // Baleares
        'mallorca' => 'Baleares',
        'baleares' => 'Baleares',

        // Otros directos
        'valencia' => 'Valencia',
        'almeria' => 'Almería',
        'granada' => 'Granada',
        'cadiz' => 'Cádiz',
        'malaga' => 'Málaga',
        'barcelona' => 'Barcelona',
        'tarragona' => 'Tarragona',
        'albacete' => 'Albacete',
    ];


    /**
     * Limpieza base de texto geográfico
     */
    private static function clean(string $value): string
    {
        $v = mb_strtolower(trim($value));

        // quitar paréntesis
        $v = preg_replace('/\((.*?)\)/', ' $1', $v);

        // quitar símbolos
        $v = preg_replace('/[^a-záéíóúüñ\s]/u', ' ', $v);

        // compactar espacios
        $v = preg_replace('/\s+/', ' ', $v);

        return trim($v);
    }


    /**
     * Normalizar provincia
     */
    public static function province(?string $value): ?string
    {
        if (!$value)
            return null;

        $clean = self::clean($value);

        return self::$provinceMap[$clean] ?? ucfirst($clean);
    }


    /**
     * Normalizar ciudad (más simple de momento)
     */
    public static function town(?string $value): ?string
    {
        if (!$value)
            return null;

        $v = mb_strtolower(trim($value));

        $v = preg_replace('/[^a-záéíóúüñ\s]/u', ' ', $v);
        $v = preg_replace('/\s+/', ' ', $v);

        return ucfirst(trim($v));
    }
}
