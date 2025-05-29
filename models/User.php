<?php
require_once 'config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $nombre;
    public $correo;
    public $password;
    public $tipo_usuario;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Crear nuevo usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET nombre=:nombre, correo=:correo, password=:password, tipo_usuario=:tipo_usuario";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->tipo_usuario = htmlspecialchars(strip_tags($this->tipo_usuario));

        // Hash de la contraseña
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        // Vincular valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si el email ya existe
    public function emailExists() {
        $query = "SELECT id, nombre, password, tipo_usuario FROM " . $this->table_name . " WHERE correo = :correo LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->execute();

        $num = $stmt->rowCount();

        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->password = $row['password'];
            $this->tipo_usuario = $row['tipo_usuario'];
            return true;
        }
        return false;
    }

    // Validar datos del formulario
    public function validate($data) {
        $errors = [];

        // Validar nombre
        if (empty($data['nombre'])) {
            $errors[] = "El nombre es obligatorio";
        } elseif (strlen($data['nombre']) < 2) {
            $errors[] = "El nombre debe tener al menos 2 caracteres";
        }

        // Validar email
        if (empty($data['correo'])) {
            $errors[] = "El correo es obligatorio";
        } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El formato del correo no es válido";
        }

        // Validar contraseña
        if (empty($data['password'])) {
            $errors[] = "La contraseña es obligatoria";
        } elseif (strlen($data['password']) < 6) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres";
        }

        // Validar confirmación de contraseña
        if (empty($data['confirm_password'])) {
            $errors[] = "Confirma tu contraseña";
        } elseif ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Las contraseñas no coinciden";
        }

        // Validar tipo de usuario
        if (empty($data['tipo_usuario'])) {
            $errors[] = "Selecciona un tipo de usuario";
        } elseif (!in_array($data['tipo_usuario'], ['admin', 'usuario'])) {
            $errors[] = "Tipo de usuario no válido";
        }

        return $errors;
    }
}
?>
