CREATE DATABASE AYNI_Donaciones;
USE AYNI_Donaciones;

CREATE TABLE organizacion (
    id_organizacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_org VARCHAR(100),
    descripcion TEXT,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    contraseña VARCHAR(255),
    tipo_usuario ENUM('Donante', 'Organización', 'Administrador'),
    estado ENUM('activo', 'inactivo'),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE necesidades (
    id_necesidad INT AUTO_INCREMENT PRIMARY KEY,
    id_organizacion INT,
    id_usuario INT,
    tipo_donacion VARCHAR(50),
    descripcion TEXT,
    estado ENUM('pendiente', 'aprobada', 'rechazada'),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_organizacion) REFERENCES organizacion(id_organizacion),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE donaciones (
    id_donacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_necesidad INT,
    cantidad INT,
    comentario TEXT,
    estado ENUM('enviado', 'recibido', 'cancelado'),
    fecha_donacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_necesidad) REFERENCES necesidades(id_necesidad)
);

INSERT INTO organizacion (nombre_org, descripcion, estado) 
VALUES ('Olla Común San Juan', 'Olla común para familias necesitadas', 'activo');

INSERT INTO usuarios (nombre, correo, contraseña, tipo_usuario, estado) 
VALUES ('Admin', 'admin@ayni.com', '$2y$10$3z7X9Y4k3z7X9Y4k3z7X9Y4k3z7X9Y4k3z7X9Y4k3z7X9Y4k3z7X', 'Administrador', 'activo');

INSERT INTO necesidades (id_organizacion, id_usuario, tipo_donacion, descripcion, estado) 
VALUES (1, 1, 'Alimentos', 'Necesitamos arroz y aceite', 'pendiente');