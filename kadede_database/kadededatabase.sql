-- Crear la base de datos de la web Kadede.es
CREATE DATABASE kadede;
-- Cambiar el charset de la base de datos a utf-8
ALTER DATABASE kadede CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE kadede;

-- Crear todas las tablas de la base de datos

DROP TABLE IF EXISTS evento;

CREATE TABLE evento (
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id Evento',
	Nombre VARCHAR(50) NOT NULL COMMENT 'Nombre del Evento',
	Fecha DATE NOT NULL COMMENT 'Fecha Creacion',
	Hora TIME NOT NULL COMMENT 'Hora Creacion',
	FechaModificacion DATE NOT NULL COMMENT 'Fecha Modificacion',
	HoraModificacion TIME NOT NULL COMMENT 'Hora Modificacion',
	Autor VARCHAR(50) NOT NULL COMMENT 'Nombre del Autor',
	Descripcion VARCHAR(5000) NOT NULL COMMENT 'Descripcion del Evento',
	Publicado INT NOT NULL COMMENT 'Publicado',
	Miniatura VARCHAR(500) NOT NULL COMMENT 'Url Miniatura',
	PRIMARY KEY (id)
);
ALTER TABLE evento CONVERT TO CHARACTER SET utf8;



DROP TABLE IF EXISTS imagen;

CREATE TABLE imagen (
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id Imagen',
	Nombre VARCHAR(50) NOT NULL COMMENT 'Nombre de Imagen',
	TextoPie VARCHAR(50) NOT NULL COMMENT 'Pie de Imagen',
	Path VARCHAR(500) NOT NULL COMMENT 'Url Imagen',
	Creditos VARCHAR(50) NOT NULL COMMENT 'Nombre de Creditos',
	UrlCreditos VARCHAR(500) NOT NULL COMMENT 'Url Creditos',
	Id_Eventos INT UNSIGNED NOT NULL COMMENT 'Id Eventos',
	PRIMARY KEY (Id),
	FOREIGN KEY (Id_Eventos)
	REFERENCES evento(Id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);
ALTER TABLE imagen CONVERT TO CHARACTER SET utf8;

DROP TABLE IF EXISTS comentarios;

CREATE TABLE comentarios (
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id Comentario',
	Nombre VARCHAR(50) NOT NULL COMMENT 'Autor Comentario',
	Fecha DATE NOT NULL COMMENT 'Fecha Creacion',
	Hora TIME NOT NULL COMMENT 'Hora Creacion',
	Email VARCHAR(50) NOT NULL COMMENT 'Email Creador',
	Descripcion VARCHAR(500) NOT NULL COMMENT 'Descripcion del Comentario',
	IP VARCHAR(16) NOT NULL COMMENT 'Direccion IP del Comentario',
	Id_Eventos INT UNSIGNED NOT NULL COMMENT 'Id Eventos',
	PRIMARY KEY (Id),
	FOREIGN KEY (Id_Eventos)
	REFERENCES evento(Id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);


ALTER TABLE comentarios CONVERT TO CHARACTER SET utf8;

CREATE TABLE videos(
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id Video',
	Nombre VARCHAR(50) NOT NULL COMMENT 'Nombre Video',
	Fecha DATE NOT NULL COMMENT 'Fecha Creacion',
	Hora TIME NOT NULL COMMENT 'Hora Creacion',
	Path VARCHAR(500) NOT NULL COMMENT 'Url Video',
	Id_Eventos INT UNSIGNED NOT NULL COMMENT 'Id Eventos',
	PRIMARY KEY (Id),
	FOREIGN KEY (Id_Eventos)
	REFERENCES evento(Id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);

DROP TABLE IF EXISTS etiquetas;

CREATE TABLE etiquetas(
	Id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Nombre VARCHAR(50) NOT NULL,
	PRIMARY KEY (Id)
);

ALTER TABLE etiquetas CONVERT TO CHARACTER SET utf8;

DROP TABLE IF EXISTS etiquetado;

CREATE TABLE etiquetado(
	Id_Eventos INT UNSIGNED NOT NULL COMMENT 'Evento',
	Id_Etiqueta INT UNSIGNED NOT NULL COMMENT 'Etiqueta',
	PRIMARY KEY (Id_Eventos,Id_Etiqueta),
	FOREIGN KEY (Id_Eventos) REFERENCES evento(Id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT,
	FOREIGN KEY (Id_Etiqueta) REFERENCES etiquetas(Id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);

DROP TABLE IF EXISTS prohibidas;

CREATE TABLE prohibidas(
	Nombre VARCHAR(50) NOT NULL COMMENT 'Palabra',
	PRIMARY KEY (Nombre)
);

DROP TABLE IF EXISTS general;

CREATE TABLE general (
	Titulo VARCHAR(50) NOT NULL COMMENT 'Titulo de pagina de informacion general',
	Cuerpo VARCHAR(2000) NOT NULL COMMENT 'Cuerpo de pagina de informacion general',
	PRIMARY KEY (Titulo)
);

ALTER TABLE general CONVERT TO CHARACTER SET utf8;


DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
	Email VARCHAR(30) NOT NULL,
	Nombre VARCHAR(50) NOT NULL,
	Fecha_Nacimiento DATE NOT NULL,
	Passwd VARCHAR(255) NOT NULL COMMENT 'Contraseña del usuario hasheada',
	Rol ENUM('registered','mod', 'manager', 'super') NOT NULL,
	PRIMARY KEY (Email)
);

-- Creación de usuario para conectarse a la BD
DROP USER IF EXISTS 'kadede_user'@'localhost';
CREATE USER 'kadede_user'@'localhost' IDENTIFIED BY 'kadede_User123_user';
-- Otorgamos permisos de lectura e inserción de datos
GRANT SELECT ON kadede.* TO 'kadede_user'@'localhost';
GRANT INSERT ON kadede.* TO 'kadede_user'@'localhost';
GRANT DELETE ON kadede.* TO 'kadede_user'@'localhost';
GRANT UPDATE ON kadede.* TO 'kadede_user'@'localhost';
FLUSH PRIVILEGES;
