-- Script SQL para el taller BiblioExpress
CREATE DATABASE IF NOT EXISTS biblio_express CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblio_express;

CREATE TABLE IF NOT EXISTS libro (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    isbn VARCHAR(30) NOT NULL,
    ano_publicacion INT NOT NULL,
    idioma VARCHAR(50) NOT NULL,
    numero_paginas INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO libro (titulo, isbn, ano_publicacion, idioma, numero_paginas) VALUES
('Cien años de soledad', '978-0307474728', 1967, 'Español', 471),
('Arquitectura Limpia', '978-8441542914', 2017, 'Español', 432),
('Clean Code', '978-0132350884', 2008, 'Inglés', 464);

