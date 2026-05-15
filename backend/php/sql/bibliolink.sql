@@ -0,0 +1,97 @@
-- Eliminar usuario si existe
DROP USER IF EXISTS 'MEDAC'@'localhost';

-- Eliminar base de datos si existe
DROP SCHEMA IF EXISTS intercambios_bd;

-- SOLO SI NO ESTÁ CREADO
CREATE USER 'MEDAC'@'localhost' IDENTIFIED BY 'MEDAC';
GRANT ALL PRIVILEGES ON intercambios_bd.* TO 'MEDAC'@'localhost';
FLUSH PRIVILEGES;

-- Crear base de datos
CREATE SCHEMA intercambios_bd;
USE intercambios_bd;

CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    tipo_suscripcion VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE libros (
    id_libro INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    precio FLOAT NOT NULL,
    tipo_oferta VARCHAR(50) NOT NULL,
    disponible BOOLEAN NOT NULL DEFAULT TRUE,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE intercambios (
    id_intercambio INT PRIMARY KEY AUTO_INCREMENT,
    id_libro INT NOT NULL,
    id_usuario_interesado INT NOT NULL,
    fecha DATE NOT NULL,
    estado VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_usuario_interesado) REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE notificaciones (
    id_notificacion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario_destino INT NOT NULL,
    id_intercambio INT NOT NULL,
    mensaje VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    leida BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_usuario_destino) REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_intercambio) REFERENCES intercambios(id_intercambio)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Insertar usuarios
INSERT INTO usuarios (nombre_usuario, email, contrasena, tipo_suscripcion) VALUES
('Carlos Ruiz', 'carlos@email.com', 'pass123', 'gratuita'),
('Laura Gómez', 'laura@email.com', 'laura456', 'premium'),
('Miguel Torres', 'miguel@email.com', 'miguel789', 'gratuita'),
('Ana Martínez', 'ana@email.com', 'ana321', 'premium'),
('David López', 'david@email.com', 'david654', 'gratuita');

-- Insertar libros
INSERT INTO libros (titulo, autor, descripcion, precio, tipo_oferta, disponible, id_usuario) VALUES
('Cien Años de Soledad', 'Gabriel García Márquez', 'Novela clásica latinoamericana', 15.99, 'venta', TRUE, 1),
('El Señor de los Anillos', 'J.R.R. Tolkien', 'Fantasía épica', 25.50, 'intercambio', TRUE, 2),
('1984', 'George Orwell', 'Distopía política', 12.00, 'venta', TRUE, 3),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 'Clásico de la literatura española', 18.75, 'intercambio', TRUE, 4),
('La Sombra del Viento', 'Carlos Ruiz Zafón', 'Misterio literario', 14.20, 'venta', TRUE, 5),
('Harry Potter y la Piedra Filosofal', 'J.K. Rowling', 'Fantasía juvenil', 20.00, 'intercambio', TRUE, 1),
('El Código Da Vinci', 'Dan Brown', 'Thriller de misterio', 13.45, 'venta', TRUE, 2),
('Los Juegos del Hambre', 'Suzanne Collins', 'Ciencia ficción juvenil', 16.80, 'intercambio', TRUE, 3);

-- Insertar intercambios
INSERT INTO intercambios (id_libro, id_usuario_interesado, fecha, estado) VALUES
(2, 1, '2026-02-01', 'pendiente'),
(4, 3, '2026-02-05', 'aceptado'),
(6, 5, '2026-02-10', 'rechazado'),
(1, 2, '2026-02-12', 'pendiente'),
(3, 4, '2026-02-15', 'aceptado');

INSERT INTO notificaciones (id_usuario_destino, id_intercambio, mensaje, fecha, leida) VALUES
(2, 1, 'Carlos Ruiz ha solicitado intercambiar El SeÃ±or de los Anillos.', '2026-02-01 10:00:00', FALSE),
(4, 2, 'Miguel Torres ha solicitado intercambiar Don Quijote de la Mancha.', '2026-02-05 11:30:00', TRUE),
(1, 3, 'David LÃ³pez ha solicitado intercambiar Harry Potter y la Piedra Filosofal.', '2026-02-10 16:45:00', TRUE);