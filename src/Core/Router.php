<?php
namespace App\Core;

final class Router
{
  private static array $r = ['GET' => [], 'POST' => []];

  public static function get($pattern, $action)
  {
    self::$r['GET'][] = [$pattern, $action];
  }

  public static function post($pattern, $action)
  {
    self::$r['POST'][] = [$pattern, $action];
  }

  public static function dispatch($method, $uri)
  {
    $routes = self::$r[$method] ?? [];

    foreach ($routes as [$pattern, $action]) {

      // Convertir /property/{id} → regex
      $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
      $regex = '#^' . $regex . '$#';

      if (preg_match($regex, $uri, $matches)) {

        array_shift($matches); // quitar match completo

        // Ejecutar acción
        if (is_array($action)) {
          $controller = new $action[0];
          $controller->{$action[1]}(...$matches);
        } else {
          $action(...$matches);
        }

        return;
      }
    }

    // 404 real
    http_response_code(404);
    echo '404 Not Found';
  }
}
