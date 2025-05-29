<?php
// Configuración general del sistema
define('APP_NAME', 'Sistema de Registro');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/Login-Register');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'login_register_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de seguridad
define('SESSION_TIMEOUT', 3600); // 1 hora en segundos
define('PASSWORD_MIN_LENGTH', 6);
define('MAX_LOGIN_ATTEMPTS', 5);

// Configuración de email (para futuras funcionalidades)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('FROM_EMAIL', 'noreply@example.com');
define('FROM_NAME', APP_NAME);

// Configuración de archivos
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Configuración de la aplicación
define('DEFAULT_TIMEZONE', 'America/Mexico_City');
define('DATE_FORMAT', 'd/m/Y');
define('DATETIME_FORMAT', 'd/m/Y H:i:s');

// Configurar zona horaria
date_default_timezone_set(DEFAULT_TIMEZONE);

// Configuración de errores (cambiar en producción)
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Configuración de ambiente
define('APP_ENV', 'development'); // development, production

// Mensajes del sistema
define('MESSAGES', [
    'LOGIN_SUCCESS' => 'Has iniciado sesión exitosamente',
    'LOGIN_ERROR' => 'Credenciales incorrectas',
    'REGISTER_SUCCESS' => 'Usuario registrado exitosamente',
    'REGISTER_ERROR' => 'Error al registrar el usuario',
    'LOGOUT_SUCCESS' => 'Has cerrado sesión exitosamente',
    'EMAIL_EXISTS' => 'Este correo ya está registrado',
    'REQUIRED_FIELDS' => 'Todos los campos son obligatorios',
    'INVALID_EMAIL' => 'El formato del correo no es válido',
    'PASSWORD_MISMATCH' => 'Las contraseñas no coinciden',
    'WEAK_PASSWORD' => 'La contraseña debe tener al menos ' . PASSWORD_MIN_LENGTH . ' caracteres'
]);

// URLs del sistema
define('URLS', [
    'HOME' => APP_URL,
    'REGISTER' => APP_URL . '?route=register',
    'LOGIN' => APP_URL . '?route=login',
    'DASHBOARD' => APP_URL . '?route=dashboard',
    'LOGOUT' => APP_URL . '?route=logout'
]);
?>
