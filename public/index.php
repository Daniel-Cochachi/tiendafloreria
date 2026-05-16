<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/config.php';
require_once '../config/Database.php';
require_once '../app/core/helpers.php';
require_once '../app/core/Router.php';
require_once '../app/core/Controller.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializar router
$router = new Router();
