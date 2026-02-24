# PHP MVC Skeleton

Pequeño esqueleto para apps PHP “nativas” con MVC ligero, autoload PSR-4 y enrutador simple.

---
# Autor

Max Serratosa[https://maxserratosa.es]

---

## Requisitos

- PHP ≥ 8.0 (probado con 8.2)
- Composer
- Servidor web apuntando a `public/` como **DocumentRoot** (Apache/Nginx) o `php -S`

---

## Estructura de carpetas

```
project/
├─ app/
│  ├─ config/
│  │  ├─ app.php            # Ajustes globales (env, debug, timezone…)
│  │  └─ database.php       # Conexiones de BD por entorno (dev/prod/test)
│  ├─ Controllers/
│  │  └─ HomeController.php # Controladores MVC (namespace App\Controllers)
│  ├─ helpers/              # Funciones auxiliares propias (opcional)
│  ├─ lib/                  # Librerías “manuales” no-Composer (opcional)
│  ├─ models/               # Modelos / repositorios de dominio (opcional)
│  ├─ routes/
│  │  └─ web.php            # Definición de rutas HTTP (usa App\Core\Router)
│  ├─ views/
│  │  ├─ Layout/            # Layouts (plantillas maestras)
│  │  ├─ Partials/          # Partials (header, footer, menús…)
│  │  └─ home.php           # Vistas PHP puras (renderizadas desde controladores)
│  ├─ .htaccess             # (opcional) reglas internas, no expuesto públicamente
│  └─ init.php              # Bootstrap de la app (errores, sesión, constantes…)
├─ public/                  # **Única** carpeta pública (DocumentRoot)
│  ├─ assets/
│  │  ├─ css/ img/ js/      # Estáticos servidos directamente
│  ├─ .htaccess             # Rewrite a index.php (si usas Apache)
│  └─ index.php             # Front Controller: carga autoload, rutas y despacha
├─ src/
│  ├─ Core/
│  │  ├─ DB.php             # Conexión PDO (multi-entorno) con caché por request
│  │  └─ Router.php         # Enrutador mínimo (GET/POST + dispatch)
│  └─ Support/
│     └─ Config.php         # Loader de config tipo Config::get('archivo.clave')
├─ vendor/                  # Composer (autoload, dependencias)
├─ .htaccess                # Desvía a /public
└─ composer.json            # Autoload PSR-4 y dependencias
```

---

## Instalación

```bash
composer install
composer dump-autoload    # tras cambios de estructura/namespaces
```

Servidor embebido de PHP:
```bash
php -S localhost:8000 -t public
```

Apache (en `public/.htaccess`):
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

> Asegúrate de que el **DocumentRoot** del virtual host apunta a `public/`.

---

## Autoload (PSR-4)

`composer.json` mapea namespaces a carpetas reales:

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/",
      "App\\Controllers\\": "app/Controllers/",
      "App\\Models\\": "app/models/"
    }
  }
}
```

---

## Ciclo de petición

1. **Navegador → `public/index.php`**  
   Carga Composer, define `BASE_PATH`, ejecuta `app/init.php`, carga rutas (`app/routes/web.php`) y despacha.

2. **Router (`src/Core/Router.php`)**  
   Resuelve método/URI y ejecuta el handler (closure o `[Controller::class, 'método']`).

3. **Controller (`app/Controllers/*`)**  
   Orquesta la lógica, pide datos a modelos/servicios y **renderiza** una vista (`require VIEW_PATH . '/archivo.php'`).

4. **Vista (`app/views/*`)**  
   Plantilla PHP simple. Puedes componer con `Layout/` y `Partials/`.

---

## Configuración

### `app/config/app.php`
```php
return [
  'env'      => getenv('APP_ENV') ?: 'dev', // dev | prod | test
  'debug'    => true,
  'timezone' => 'Europe/Madrid',
];
```

### `app/config/database.php`
```php
return [
  'default' => 'dev',
  'connections' => [
    'dev' => [
      'driver'=>'mysql','host'=>'127.0.0.1','port'=>3306,
      'database'=>'miapp_dev','username'=>'root','password'=>'secret',
      'charset'=>'utf8mb4',
    ],
    'prod' => [
      'driver'=>'mysql','host'=>'10.0.0.5','port'=>3306,
      'database'=>'miapp','username'=>'miusuario','password'=>'supersecreto',
      'charset'=>'utf8mb4',
    ],
  ],
];
```

### Acceso a configuración
```php
use Src\Support\Config;

$env   = Config::get('app.env');                 // 'dev' | 'prod' | 'test'
$debug = Config::get('app.debug', false);        // bool
$dbCfg = Config::get('database.connections.dev');// array
```

---

## Base de datos (PDO)

`src/Core/DB.php` expone una conexión por entorno:

```php
use App\Core\DB;

$pdo = DB::conn();       // usa env actual (app.env)
$pdo = DB::conn('prod'); // fuerza conexión 'prod'
```

Ajustes por defecto:
- `charset=utf8mb4`
- `PDO::ERRMODE_EXCEPTION`
- `PDO::FETCH_ASSOC`
- `PDO::ATTR_EMULATE_PREPARES = false`

---

## Rutas

Decláralas en `app/routes/web.php`:

```php
<?php
use App\Core\Router;
use App\Controllers\HomeController;

Router::get('/', [HomeController::class, 'index']);
// Router::post('/login', [AuthController::class, 'login']);
```

---

## Controladores

Ejemplo `app/Controllers/HomeController.php`:

```php
<?php
namespace App\Controllers;

use App\Core\DB;

class HomeController {
  public function index(): void {
    $pdo = DB::conn();                 // si necesitas BD
    require VIEW_PATH . '/home.php';   // render
  }
}
```

---

## Vistas

- `app/views/Layout/` – layout maestro (`main.php`)
- `app/views/Partials/` – header, footer, menús…
- `app/views/home.php` – vista de ejemplo

> Más adelante puedes añadir un helper `View` para layouts/sections (`View::render('home', ['title'=>'...'])`).

---

## Bootstrap de la app

`app/init.php` se ejecuta en cada petición:
- configura `timezone` y `display_errors` según `app.debug`
- inicia sesión si procede
- define constantes útiles (`VIEW_PATH`, `STORAGE_PATH`, etc.)

---

## Convenciones & notas

- Respeta **PSR-4** y mayúsculas de carpetas (p. ej., `Controllers`).
- **No expongas** `app/`, `src/` ni `config/`: el público solo ve `public/`.
- No subas credenciales reales al repo: usa variables de entorno (`APP_ENV`, …) o inyecta config en despliegue.
- Dónde poner qué:
  - `helpers/`: funciones sueltas reutilizables.
  - `lib/`: librerías de terceros no disponibles vía Composer.
  - `models/`: entidades/repositorios/servicios de dominio (la **M** de MVC).

---

## Roadmap (ideas)

- Helper `View` con layouts/sections.
- Middlewares en `src/Http/Middleware`.
- Tests con PHPUnit (`/tests`).
- CLI (`bin/console`) para migraciones/seeders/tareas.

---