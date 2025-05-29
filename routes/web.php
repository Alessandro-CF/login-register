<?php
// Rutas de la aplicación

$routes = [
    'register' => 'AuthController@showRegister',
    'register-process' => 'AuthController@processRegister',
    'login' => 'AuthController@showLogin',
    'login-process' => 'AuthController@processLogin',
    'dashboard' => 'DashboardController@index',
    'logout' => 'AuthController@logout'
];

function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['SCRIPT_NAME']);
    return $protocol . $host . $path;
}
?>
