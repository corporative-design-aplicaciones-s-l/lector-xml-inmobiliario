<?php
namespace App\Services;

use App\Services\FeatureNormalizer;
use App\Services\TextNormalizer;


class Xml
{
    public static function properties(): array
    {
        $dir = STORAGE_PATH . '/xml';
        if (!is_dir($dir)) {
            return [];
        }

        $all = [];

        foreach (glob($dir . '/*.xml') as $file) {

            $xml = @simplexml_load_file($file);
            if (!$xml)
                continue;

            foreach ($xml->property as $p) {

                /* ================= IMAGES ================= */
                $images = [];
                if (isset($p->images->image)) {
                    foreach ($p->images->image as $img) {
                        $images[] = (string) $img->url;
                    }
                }

                /* ================= LOCATION ================= */
                $lat = isset($p->location->latitude) ? (float) $p->location->latitude : null;
                $lng = isset($p->location->longitude) ? (float) $p->location->longitude : null;

                /* ================= FEATURES ================= */
                $features = isset($p->features->feature)
                    ? FeatureNormalizer::normalizeList(
                        array_map('strval', iterator_to_array($p->features->feature))
                    )
                    : [];

                /* ================= PROPERTY ARRAY ================= */
                $all[] = [

                    /* BASIC */
                    'id' => (string) $p->id,
                    'ref' => (string) $p->ref,
                    'price' => (int) $p->price,
                    'currency' => (string) ($p->currency ?? 'EUR'),
                    'type' => (string) $p->type,
                    'status' => (string) ($p->price_freq ?? 'sale'),

                    /* LOCATION */
                    'location' => [
                        'town' => (string) $p->town,
                        'province' => (string) $p->province,
                        'area' => (string) ($p->location_detail ?? ''),
                        'lat' => $lat,
                        'lng' => $lng,
                    ],

                    /* SURFACE */
                    'surface' => [
                        'built' => (int) ($p->surface_area->built ?? 0),
                    ],

                    /* DETAILS */
                    'details' => [
                        'beds' => (int) $p->beds,
                        'baths' => (int) $p->baths,
                        'pool' => ((int) ($p->pool ?? 0)) === 1,
                        'garage' => in_array('garage', array_map('strtolower', $features)),
                        'new_build' => ((int) ($p->new_build ?? 0)) === 1,
                        'leasehold' => ((int) ($p->leasehold ?? 0)) === 1,
                        'part_ownership' => ((int) ($p->part_ownership ?? 0)) === 1,
                    ],

                    /* ENERGY */
                    'energy' => [
                        'consumption' => trim((string) ($p->energy_rating->consumption ?? '')),
                        'emissions' => trim((string) ($p->energy_rating->emissions ?? '')),
                    ],

                    /* DESCRIPTION */

                    'desc' => [
                        'en' => TextNormalizer::description((string) ($p->desc->en ?? '')),
                        'es' => TextNormalizer::description((string) ($p->desc->es ?? '')),
                    ],


                    /* FEATURES */
                    'features' => $features,

                    /* MEDIA */
                    'media' => [
                        'images' => $images,
                        'video' => (string) ($p->video_url ?? ''),
                    ],

                    /* URL */
                    'url' => (string) ($p->url->en ?? ''),
                ];
            }
        }

        return $all;
    }
}
