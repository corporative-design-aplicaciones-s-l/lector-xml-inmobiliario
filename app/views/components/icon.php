<?php

function icon(string $name, string $class = ''): void
{
    $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/icons/{$name}.svg";

    if (!file_exists($file)) {
        return;
    }

    $svg = file_get_contents($file);

    // insertar clase CSS en el SVG
    if ($class) {
        $svg = preg_replace('/<svg /', '<svg class="' . htmlspecialchars($class) . '" ', $svg, 1);
    }

    echo $svg;
}
