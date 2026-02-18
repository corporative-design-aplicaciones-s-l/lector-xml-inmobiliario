<?php
namespace App\Services;

class LeadStorage
{
    public static function save(array $data): void
    {
        $dir = STORAGE_PATH . '/leads';

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = $dir . '/' . date('Y-m-d') . '.json';

        $existing = [];

        if (file_exists($file)) {
            $existing = json_decode(file_get_contents($file), true) ?? [];
        }

        $existing[] = $data;

        file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
