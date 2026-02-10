<?php

function view(string $view, array $data = [])
{
    extract($data);

    ob_start();
    require VIEW_PATH . "/{$view}.php";
    $content = ob_get_clean();

    require VIEW_PATH . '/layout/layout.php';
}
