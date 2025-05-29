<?php
// Configuración de la base de datos
class Database {
    private $host = 'localhost';
    private $db_name = 'login_register_db';
    private $username = 'root';
    private $password = '';
    private $conn = null;

    public function getConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Crear tabla de usuarios si no existe
function createUsersTable() {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        tipo_usuario ENUM('admin', 'usuario') DEFAULT 'usuario',
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    try {
        $db->exec($query);
    } catch(PDOException $e) {
        echo "Error al crear tabla: " . $e->getMessage();
    }
}

// Ejecutar la creación de tabla
createUsersTable();
?>
