-- Script SQL para crear la base de datos y tabla de usuarios
-- Ejecutar este script si tienes problemas con la creación automática

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS login_register_db 
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE login_register_db;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('admin', 'usuario') DEFAULT 'usuario',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Índices para mejor rendimiento
CREATE INDEX idx_correo ON users(correo);
CREATE INDEX idx_tipo_usuario ON users(tipo_usuario);
CREATE INDEX idx_fecha_creacion ON users(fecha_creacion);

-- Insertar usuarios de ejemplo (opcional)
-- Contraseña para todos: "123456"
INSERT INTO users (nombre, correo, password, tipo_usuario) VALUES
('Administrador', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Usuario Demo', 'usuario@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'usuario')
ON DUPLICATE KEY UPDATE 
nombre = VALUES(nombre);

-- Verificar que todo se creó correctamente
SELECT 'Base de datos y tabla creadas exitosamente' as mensaje;
SELECT COUNT(*) as total_usuarios FROM users;
