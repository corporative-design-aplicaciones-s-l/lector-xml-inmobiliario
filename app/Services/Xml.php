<?php
namespace App\Services;

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
                    'images' => $images,
                    'url' => (string) ($p->url->en ?? ''),
                ];
            }
        }

        return $all;
    }
}
