<?php
namespace App\Services;

class FeatureNormalizer
{
    /**
     * Patrones semánticos → etiqueta final
     */
    private static array $patterns = [

        // PISCINA
        '/private.*pool|piscina privada/i' => 'Piscina privada',
        '/communal.*pool|piscina comunitaria/i' => 'Piscina comunitaria',
        '/pool|piscina/i' => 'Piscina',

        // VISTAS
        '/sea view|vistas al mar|views.*sea/i' => 'Vistas al mar',
        '/mountain/i' => 'Vistas a la montaña',
        '/golf/i' => 'Vistas al golf',
        '/panoramic/i' => 'Vistas panorámicas',

        // CLIMA
        '/air.?cond/i' => 'Aire acondicionado',
        '/underfloor/i' => 'Suelo radiante',
        '/heating/i' => 'Calefacción',

        // EXTERIOR
        '/terrace|terraza/i' => 'Terraza',
        '/garden|jard/i' => 'Jardín',
        '/solarium/i' => 'Solárium',
        '/balcon/i' => 'Balcón',

        // PARKING
        '/garage|garaje/i' => 'Garaje',
        '/parking/i' => 'Parking',

        // SEGURIDAD
        '/alarm/i' => 'Alarma',
        '/security/i' => 'Seguridad',
        '/reinforced door/i' => 'Puerta blindada',

        // INTERIOR
        '/lift|elevator|ascensor/i' => 'Ascensor',
        '/storage|trastero/i' => 'Trastero',
        '/furnished|amueblado/i' => 'Amueblado',

        // UBICACIÓN
        '/near.*beach|cerca del mar|beachside/i' => 'Cerca del mar',
        '/near.*golf|cerca de golf/i' => 'Cerca de golf',
        '/urbanisation|urbanización/i' => 'Urbanización',
    ];


    /**
     * Limpieza agresiva
     */
    private static function clean(string $value): string
    {
        $v = mb_strtolower(trim($value));

        // quitar prefijos comunes
        $v = preg_replace('/^(features|setting|orientation)\s*-\s*/i', '', $v);

        // quitar números y medidas
        $v = preg_replace('/\d+.*$/', '', $v);

        // quitar símbolos raros
        $v = preg_replace('/[^a-záéíóúüñ\s]/u', ' ', $v);

        // compactar espacios
        $v = preg_replace('/\s+/', ' ', $v);

        return trim($v);
    }


    /**
     * Normaliza lista completa
     */
    public static function normalizeList(array $features): array
    {
        $result = [];

        foreach ($features as $raw) {

            $clean = self::clean($raw);

            if ($clean === '' || strlen($clean) < 3) {
                continue;
            }

            foreach (self::$patterns as $regex => $label) {
                if (preg_match($regex, $clean)) {
                    $result[$label] = true;
                    continue 2;
                }
            }
        }

        ksort($result);

        return array_keys($result);
    }
}
