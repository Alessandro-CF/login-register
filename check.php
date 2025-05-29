<?php
// Archivo de verificación del sistema
// Acceder a: http://localhost/Login-Register/check.php

echo "<h1>🔍 Verificación del Sistema</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .check { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .success { color: #22c55e; }
    .error { color: #ef4444; }
    .warning { color: #f59e0b; }
    .info { color: #3b82f6; }
    h2 { border-bottom: 2px solid #ddd; padding-bottom: 10px; }
</style>";

// Verificar PHP
echo "<div class='check'>";
echo "<h2>📋 Información de PHP</h2>";
echo "<p><strong>Versión de PHP:</strong> " . phpversion() . "</p>";
echo "<p><strong>Versión mínima requerida:</strong> 7.4</p>";
if (version_compare(phpversion(), '7.4', '>=')) {
    echo "<p class='success'>✅ Versión de PHP compatible</p>";
} else {
    echo "<p class='error'>❌ Versión de PHP no compatible</p>";
}
echo "</div>";

// Verificar extensiones
echo "<div class='check'>";
echo "<h2>🔧 Extensiones PHP</h2>";
$extensions = ['pdo', 'pdo_mysql', 'session', 'json'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p class='success'>✅ $ext: Disponible</p>";
    } else {
        echo "<p class='error'>❌ $ext: No disponible</p>";
    }
}
echo "</div>";

// Verificar estructura de archivos
echo "<div class='check'>";
echo "<h2>📁 Estructura de Archivos</h2>";
$files = [
    'index.php',
    'config/database.php',
    'config/config.php',
    'controllers/AuthController.php',
    'controllers/DashboardController.php',
    'models/User.php',
    'views/register.php',
    'views/login.php',
    'views/dashboard.php',
    'routes/web.php',
    'public/js/register.js',
    'public/js/login.js',
    'public/css/styles.css'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p class='success'>✅ $file: Existe</p>";
    } else {
        echo "<p class='error'>❌ $file: No encontrado</p>";
    }
}
echo "</div>";

// Verificar permisos de escritura
echo "<div class='check'>";
echo "<h2>🔐 Permisos de Archivos</h2>";
$writable_dirs = ['public', 'public/css', 'public/js'];
foreach ($writable_dirs as $dir) {
    if (is_writable($dir)) {
        echo "<p class='success'>✅ $dir: Escribible</p>";
    } else {
        echo "<p class='warning'>⚠️ $dir: No escribible (puede causar problemas)</p>";
    }
}
echo "</div>";

// Verificar conexión a base de datos
echo "<div class='check'>";
echo "<h2>🗄️ Conexión a Base de Datos</h2>";
try {
    require_once 'config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "<p class='success'>✅ Conexión exitosa a la base de datos</p>";
        
        // Verificar si existe la tabla users
        $stmt = $conn->prepare("SHOW TABLES LIKE 'users'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<p class='success'>✅ Tabla 'users' existe</p>";
            
            // Contar usuarios
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p class='info'>ℹ️ Total de usuarios registrados: " . $result['count'] . "</p>";
        } else {
            echo "<p class='warning'>⚠️ Tabla 'users' no existe (se creará automáticamente)</p>";
        }
    } else {
        echo "<p class='error'>❌ No se pudo conectar a la base de datos</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Error de base de datos: " . $e->getMessage() . "</p>";
    echo "<p class='info'>💡 Asegúrate de que MySQL esté corriendo y la base de datos 'login_register_db' exista</p>";
}
echo "</div>";

// Verificar configuración de sesiones
echo "<div class='check'>";
echo "<h2>🔑 Configuración de Sesiones</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "<p class='success'>✅ Sesiones habilitadas</p>";
echo "<p class='info'>ℹ️ ID de sesión: " . session_id() . "</p>";
echo "</div>";

// URLs del sistema
echo "<div class='check'>";
echo "<h2>🌐 URLs del Sistema</h2>";
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
echo "<p><a href='$base_url' target='_blank'>🏠 Página Principal (Registro)</a></p>";
echo "<p><a href='$base_url?route=register' target='_blank'>📝 Formulario de Registro</a></p>";
echo "<p><a href='$base_url?route=login' target='_blank'>🔐 Formulario de Login</a></p>";
echo "</div>";

// Información del servidor
echo "<div class='check'>";
echo "<h2>🖥️ Información del Servidor</h2>";
echo "<p><strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Host:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p><strong>Protocolo:</strong> " . $_SERVER['SERVER_PROTOCOL'] . "</p>";
echo "<p><strong>Método:</strong> " . $_SERVER['REQUEST_METHOD'] . "</p>";
echo "</div>";

echo "<div class='check'>";
echo "<h2>✅ Conclusión</h2>";
echo "<p>Si todos los elementos muestran ✅, el sistema debería funcionar correctamente.</p>";
echo "<p>Si hay elementos con ❌, revisa la configuración correspondiente.</p>";
echo "<p>Si hay elementos con ⚠️, pueden funcionar pero podrían causar problemas menores.</p>";
echo "</div>";
?>

<div class="check">
    <h2>🚀 Próximos Pasos</h2>
    <ol>
        <li>Ve a la <a href="index.php">página principal</a> para probar el registro</li>
        <li>Crea una cuenta de usuario</li>
        <li>Prueba el login con las credenciales creadas</li>
        <li>Explora el dashboard</li>
    </ol>
</div>
