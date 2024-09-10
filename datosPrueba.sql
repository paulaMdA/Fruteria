

-- Crear la base de datos pasarela
DROP DATABASE IF  EXISTS pasarela;
CREATE DATABASE pasarela;
-- Seleccionar la base de datos pasarela
USE pasarela;

-- Crear la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_usr INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(100),
    rol ENUM('vendedor', 'comprador', 'invitado') DEFAULT 'invitado'
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10, 2),
    fotos VARCHAR(100)
);

-- Crear la tabla carrito
CREATE TABLE IF NOT EXISTS carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    producto_id INT,
    cantidad INT,
    total DECIMAL(10, 2),
    estado ENUM('pendiente','comprado', 'enviado', 'entregado') DEFAULT 'pendiente',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usr),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);


-- Insertar el admin 
INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
VALUES ('Admin', 'Admin', 'admin@admin.com', 'admin', 'vendedor');

-- Insertar productos
INSERT INTO productos (nombre, descripcion, precio, fotos)
VALUES 
('Tomate', 'Tomate fresco de temporada', 1.99, '../img/tomates.jpeg'),
('Lechuga', 'Lechuga crujiente y fresca', 2.49, '../img/lechuga.jpeg'),
('Zanahoria', 'Zanahoria orgánica', 1.79, '../img/zanahorias.jpeg'),
('Pimiento', 'Pimiento rojo jugoso y sabroso', 3.29, '../img/pimientos.jpeg'),
('Brócoli', 'Brócoli fresco y saludable', 2.99, '../img/brocoli.jpeg');