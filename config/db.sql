DROP DATABASE IF EXISTS gomitas;

CREATE DATABASE gomitas;

USE gomitas;

CREATE TABLE
    administradores (
        id_admin int primary key auto_increment,
        usuario varchar(50) not null,
        email varchar(80) not null,
        password varchar(255) not null,
        estado boolean not null
    );

CREATE TABLE
    clientes (
        id_cliente int primary key auto_increment,
        usuario varchar(50) not null,
        email varchar(80) not null,
        password varchar(255) not null,
        estado boolean not null
    );

CREATE TABLE
    productos (
        id_producto INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        precio DOUBLE NOT NULL,
        cantidad int not null,
        estado boolean not null,
        foto_path VARCHAR(255)
    );

CREATE TABLE
    carrito (
        id_cliente int not null,
        id_producto int not null,
        cantidad int not null,
        total double not null,
        FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente),
        FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    );

CREATE TABLE
    ventas (
        id_venta int primary key auto_increment,
        id_cliente int not null,
        fecha date not null,
        hora time not null,
        total double not null,
        FOREIGN KEY (id_cliente) REFERENCES clientes (id_cliente)
    );

CREATE TABLE
    detalle_venta (
        id_venta int not null,
        id_producto int not null,
        cantidad int not null,
        importe double not null,
        FOREIGN KEY (id_venta) REFERENCES ventas (id_venta),
        FOREIGN KEY (id_producto) REFERENCES productos (id_producto)
    );

-- Administrador
INSERT INTO
    administradores
VALUES
    (
        DEFAULT,
        "admin",
        "admin@admin.com",
        "$2y$10$0x8N0REE0XEklLiJoJx8euRbLKJ7DJzb6/CW5gn.1ELNTqlt.mKI6",
        true
    );