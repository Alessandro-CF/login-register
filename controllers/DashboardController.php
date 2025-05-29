<?php
class DashboardController {
    
    public function index() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?route=login");
            exit;
        }
        
        $title = "Dashboard - " . $_SESSION['user_name'];
        $userName = $_SESSION['user_name'];
        $userType = $_SESSION['user_type'];
        $userId = $_SESSION['user_id'];
          // Obtener estadísticas básicas
        $stats = $this->getUserStats();
        
        // Obtener lista de usuarios si es admin
        $allUsers = [];
        if ($userType === 'admin') {
            $allUsers = $this->getAllUsers();
        }
        
        include 'views/dashboard.php';
    }
    
    private function getUserStats() {
        try {
            require_once 'config/database.php';
            $database = new Database();
            $db = $database->getConnection();
            
            // Contar total de usuarios
            $query = "SELECT COUNT(*) as total_users FROM users";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
            
            // Contar usuarios por tipo
            $query = "SELECT tipo_usuario, COUNT(*) as count FROM users GROUP BY tipo_usuario";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $userTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Usuarios registrados hoy
            $query = "SELECT COUNT(*) as today_users FROM users WHERE DATE(fecha_creacion) = CURDATE()";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $todayUsers = $stmt->fetch(PDO::FETCH_ASSOC)['today_users'];
            
            return [
                'total_users' => $totalUsers,
                'user_types' => $userTypes,
                'today_users' => $todayUsers
            ];
              } catch(PDOException $e) {
            return [
                'total_users' => 0,
                'user_types' => [],
                'today_users' => 0
            ];
        }
    }
    
    private function getAllUsers() {
        try {
            require_once 'config/database.php';
            $database = new Database();
            $db = $database->getConnection();
            
            // Obtener todos los usuarios ordenados por fecha de creación
            $query = "SELECT id, nombre, correo, tipo_usuario, fecha_creacion 
                     FROM users 
                     ORDER BY fecha_creacion DESC";
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>
