<?php
require_once 'models/User.php';

class AuthController {
    
    public function showRegister() {
        $title = "Registro de Usuario";
        $errors = $_SESSION['errors'] ?? [];
        $old_data = $_SESSION['old_data'] ?? [];
        $success = $_SESSION['success'] ?? '';
        
        // Limpiar variables de sesión
        unset($_SESSION['errors'], $_SESSION['old_data'], $_SESSION['success']);
        
        include 'views/register.php';
    }

    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            
            // Validar datos
            $errors = $user->validate($_POST);
            
            if (empty($errors)) {
                // Verificar si el email ya existe
                $user->correo = $_POST['correo'];
                if ($user->emailExists()) {
                    $errors[] = "Este correo ya está registrado";
                }
            }
            
            if (empty($errors)) {
                // Crear usuario
                $user->nombre = $_POST['nombre'];
                $user->correo = $_POST['correo'];
                $user->password = $_POST['password'];
                $user->tipo_usuario = $_POST['tipo_usuario'];
                
                if ($user->create()) {
                    $_SESSION['success'] = "Usuario registrado exitosamente";
                    header("Location: ?route=register");
                    exit;
                } else {
                    $errors[] = "Error al registrar el usuario";
                }
            }
            
            // Si hay errores, guardar en sesión y redirigir
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_data'] = $_POST;
                header("Location: ?route=register");
                exit;
            }
        }
    }

    public function showLogin() {
        $title = "Iniciar Sesión";
        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? '';
        
        // Limpiar variables de sesión
        unset($_SESSION['errors'], $_SESSION['success']);
        
        include 'views/login.php';
    }

    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            
            if (empty($_POST['correo']) || empty($_POST['password'])) {
                $errors[] = "Todos los campos son obligatorios";
            } else {
                $user = new User();
                $user->correo = $_POST['correo'];
                
                if ($user->emailExists()) {
                    if (password_verify($_POST['password'], $user->password)) {
                        // Login exitoso
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['user_name'] = $user->nombre;
                        $_SESSION['user_type'] = $user->tipo_usuario;
                        $_SESSION['success'] = "Bienvenido, " . $user->nombre;
                        header("Location: ?route=dashboard");
                        exit;
                    } else {
                        $errors[] = "Contraseña incorrecta";
                    }
                } else {
                    $errors[] = "El correo no está registrado";
                }
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?route=login");
                exit;
            }
        }
    }
    
    public function logout() {
        // Destruir todas las variables de sesión
        session_unset();
        
        // Destruir la sesión
        session_destroy();
        
        // Iniciar nueva sesión para mostrar mensaje
        session_start();
        $_SESSION['success'] = "Has cerrado sesión exitosamente";
        
        // Redirigir al login
        header("Location: ?route=login");
        exit;
    }
}
?>
