<?php
namespace App\Services;

use App\Services\FeatureNormalizer;
class Xml
{
    public static function properties(): array
    {
        $dir = STORAGE_PATH . '/xml';
        if (!is_dir($dir))
            return [];

        $all = [];

        foreach (glob($dir . '/*.xml') as $file) {

            $xml = @simplexml_load_file($file);
            if (!$xml)
                continue;

            foreach ($xml->property as $p) {

                $images = [];
                if (isset($p->images->image)) {
                    foreach ($p->images->image as $img) {
                        $images[] = (string) $img->url;
                    }
                }

                $all[] = [
                    'id' => (string) $p->id,
                    'ref' => (string) $p->ref,
                    'price' => (int) $p->price,
                    'type' => (string) $p->type,
                    'town' => (string) $p->town,
                    'beds' => (int) $p->beds,
                    'baths' => (int) $p->baths,
                    'built' => (int) ($p->surface_area->built ?? 0),
                    'province' => (string) $p->province,
                    'features' => isset($p->features->feature)
                        ? FeatureNormalizer::normalizeList(array_map('strval', iterator_to_array($p->features->feature)))   
                        : [],
                    'status' => (string) ($p->price_freq ?? 'sale'),
                    'images' => $images,
                    'url' => (string) ($p->url->en ?? ''),
                ];
            }
        }

        return $all;
    }
}
