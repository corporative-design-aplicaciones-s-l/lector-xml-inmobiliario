<?php
namespace App\Services;

class XmlDownloader
{
    public static function download(array $urls): void
    {
        set_time_limit(0); // sin límite de tiempo

        $dir = STORAGE_PATH . '/xml';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        foreach ($urls as $i => $url) {

            echo "Descargando feed {$i}...\n";

            $context = stream_context_create([
                'http' => [
                    'timeout' => 60
                ]
            ]);

            $data = @file_get_contents($url, false, $context);

            if (!$data) {
                echo "❌ Error en {$url}\n";
                continue;
            }

            file_put_contents($dir . "/feed_{$i}.xml", $data);

            echo "✔ Guardado feed {$i}\n";
        }
    }
}
