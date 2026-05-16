<?php
/**
 * CONFIGURACIÓN AUTOMATIZADA (LOCAL vs PRODUCCIÓN)
 * Las credenciales se leen de archivo .env.local (NO se sube a GitHub)
 */

// Cargar variables de entorno desde .env.local
$envFile = dirname(__DIR__) . '/config/.env.local';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Detectar si estamos en local
$isLocal = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '::1');

if ($isLocal) {
    // 🏠 CONFIGURACIÓN LOCAL (Laragon / XAMPP)
    define('DB_HOST', $_ENV['DB_HOST_LOCAL'] ?? 'localhost');
    define('DB_USER', $_ENV['DB_USER_LOCAL'] ?? 'root');
    define('DB_PASS', $_ENV['DB_PASS_LOCAL'] ?? 'root');
    define('DB_NAME', $_ENV['DB_NAME_LOCAL'] ?? 'tienda_floreria');
    define('APP_URL', $_ENV['APP_URL_LOCAL'] ?? 'http://localhost/Freelancer/Florerias/tienda-floreria-mvc-php');
} else {
    // 🌐 CONFIGURACIÓN PRODUCCIÓN (Lee de .env.local)
    define('DB_HOST', $_ENV['DB_HOST'] ?? '');
    define('DB_USER', $_ENV['DB_USER'] ?? '');
    define('DB_PASS', $_ENV['DB_PASS'] ?? '');
    define('DB_NAME', $_ENV['DB_NAME'] ?? '');
    define('APP_URL', $_ENV['APP_URL'] ?? '');
}

// Configuración General
define('APP_NAME', 'Tienda Florería');

// Rutas del Sistema
define('VIEWS_PATH', dirname(__DIR__) . '/app/views/');
define('PUBLIC_PATH', dirname(__DIR__) . '/public/');
