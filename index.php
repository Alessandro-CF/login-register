<?php
// Archivo principal de la aplicación
session_start();

// Configuración básica
require_once 'config/database.php';
require_once 'routes/web.php';

// Obtener la ruta solicitada
$request = $_GET['route'] ?? 'register';

// Enrutamiento simple
switch ($request) {
    case 'register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->showRegister();
        break;
    case 'register-process':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->processRegister();
        break;
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->showLogin();
        break;    case 'login-process':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->processLogin();
        break;
    case 'dashboard':
        require_once 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
    default:
        header("Location: ?route=register");
        exit;
}
?>
