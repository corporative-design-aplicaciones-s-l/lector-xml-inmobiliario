<?php

require __DIR__ . '/../../vendor/autoload.php';

define('BASE_PATH', dirname(__DIR__, 2));

require BASE_PATH . '/app/init.php';

use App\Services\XmlDownloader;

$feeds = require BASE_PATH . '/app/config/feeds.php';

echo "Actualizando feeds...\n";

XmlDownloader::download($feeds);

echo "OK\n";
