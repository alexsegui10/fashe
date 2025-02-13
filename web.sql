DROP DATABASE IF EXISTS wallapop_alex;
CREATE DATABASE wallapop_alex;
USE wallapop_alex;

CREATE TABLE ciudades (
  id_ciudad INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE accesorios (
  id_accesorio INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255),
  id_modelo INT,
  id_estado INT,
  id_ciudad INT,
  id_marca INT,
  descripcion TEXT,
  precio DECIMAL(10,2),
  FOREIGN KEY (id_modelo) REFERENCES modelos(id_modelo),
  FOREIGN KEY (id_estado) REFERENCES estados(id_estado),
  FOREIGN KEY (id_ciudad) REFERENCES ciudades(id_ciudad),
  FOREIGN KEY (id_marca) REFERENCES marcas(id_marca)
);

CREATE TABLE marcas (
  id_marca INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);


CREATE TABLE modelos (
  id_modelo INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255),
  id_marca INT,
  FOREIGN KEY (id_marca) REFERENCES marcas(id_marca)
);

CREATE TABLE estados (
  id_estado INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE categorias (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE tipos (
  id_tipo INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE tipos_venta (
  id_tipo_venta INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE colores (
  id_color INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE materiales (
  id_material INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);


CREATE TABLE imagenes_accesorios (
  id_imagen_accesorio INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255),
  id_accesorio INT,
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio)
);

CREATE TABLE accesorios_categorias (
  id_accesorio INT,
  id_categoria INT,
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

CREATE TABLE accesorios_tipos (
  id_accesorio INT,
  id_tipo INT,
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_tipo) REFERENCES tipos(id_tipo)
);

CREATE TABLE accesorios_tipos_venta (
  id_accesorio INT,
  id_tipo_venta INT,
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_tipo_venta) REFERENCES tipos_venta(id_tipo_venta)
);

CREATE TABLE accesorios_colores (
  id_accesorio INT,
  id_color INT,
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_color) REFERENCES colores(id_color)
);

CREATE TABLE accesorios_materiales (
  id_accesorio INT,
  id_material INT,
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_material) REFERENCES materiales(id_material)
);

-- Ciudades
INSERT INTO ciudades (name, image) VALUES 
('Madrid', '/Fashe/views/img/madrid.jpg'),
('Barcelona', '/Fashe/views/img/barcelona.jpg'),
('Valencia', '/Fashe/views/img/valencia.jpg'),
('Sevilla', '/Fashe/views/img/sevilla.jpg'),
('Bilbao', '/Fashe/views/img/bilbao.jpg'),
('Málaga', '/Fashe/views/img/malaga.jpg');

-- Marcas
INSERT INTO marcas (name, image) VALUES 
('Adidas', '/Fashe/views/img/adidas.jpg'),
('Casio', '/Fashe/views/img/casio.jpg'),
('Gucci', '/Fashe/views/img/gucci.jpg'),
('Nike', '/Fashe/views/img/nike.jpg'),
('Oakley', '/Fashe/views/img/oakley.webp'),
('Rolex', '/Fashe/views/img/rolex.jpg');

-- Accesorios
INSERT INTO accesorios (name, image, id_modelo, id_estado, id_ciudad, id_marca, descripcion, precio) VALUES
('Ray-Ban Aviator', '/Fashe/views/img/aviator_negro.webp', 1, 1, 1, 1, 'Gafas de sol clásicas Ray-Ban Aviator en color negro.', 120.00),
('Oakley Holbrook', '/Fashe/views/img/holbrook_azul.jpg', 2, 1, 2, 2, 'Gafas de sol Oakley Holbrook con protección UV.', 95.00),
('Rolex Submariner', '/Fashe/views/img/rolex_submariner.jpg', 3, 2, 3, 3, 'Reloj Rolex Submariner en excelente estado.', 8500.00),
('Casio G-Shock', '/Fashe/views/img/gshock_rojo.webp', 4, 1, 4, 4, 'Reloj deportivo Casio G-Shock resistente al agua.', 120.00),
('Nike Air Backpack', '/Fashe/views/img/air_backpack.jpg', 5, 1, 5, 5, 'Mochila deportiva Nike Air con amplio almacenamiento.', 60.00),
('Adidas Classic Backpack', '/Fashe/views/img/classic_backpack.jpg', 6, 1, 6, 6, 'Mochila Adidas de estilo casual.', 45.00),
('Gucci GG Marmont', '/Fashe/views/img/gg_marmont.webp', 7, 1, 1, 2, 'Collar Gucci GG Marmont con cadena de oro.', 1500.00),
('Louis Vuitton Chain', '/Fashe/views/img/lv_chain.jpg', 8, 1, 2, 1, 'Collar Louis Vuitton con detalles exclusivos.', 2200.00);



-- Modelos
INSERT INTO modelos (name, image, id_marca) VALUES 
('Aviator', '/Fashe/views/img/aviator.jpg', 1),
('Holbrook', '/Fashe/views/img/holbrook.jpg', 2),
('Submariner', '/Fashe/views/img/submariner.jpg', 3),
('G-Shock', '/Fashe/views/img/gshock.jpg', 4),
('Air Backpack', '/Fashe/views/img/air_backpack.jpg', 5),
('Classic Backpack', '/Fashe/views/img/classic_backpack.jpg', 6),
('GG Marmont', '/Fashe/views/img/gg_marmont.jpg', 7),
('LV Chain', '/Fashe/views/img/lv_chain.jpg', 8);

-- Estados
INSERT INTO estados (name, image) VALUES 
('Nuevo', '/Fashe/views/img/nuevo.jpg'),
('Usado', '/Fashe/views/img/usado.jpg'),
('Reacondicionado', '/Fashe/views/img/reacondicionado.jpg');

-- Categorías
INSERT INTO categorias (name, image) VALUES 
('Gafas de sol', '/Fashe/views/img/gafas.jpg'),
('Relojes', '/Fashe/views/img/relojes.jpg'),
('Mochilas', '/Fashe/views/img/mochilas.jpg'),
('Collares', '/Fashe/views/img/collares.jpg');

-- Tipos
INSERT INTO tipos (name, image) VALUES 
('Casual', '/Fashe/views/img/casual.jpg'),
('Deportivo', '/Fashe/views/img/deportivo.jpg'),
('Elegante', '/Fashe/views/img/elegante.jpg');

-- Tipos de venta
INSERT INTO tipos_venta (name, image) VALUES 
('Venta directa', '/Fashe/views/img/venta_directa.jpg'),
('Subasta', '/Fashe/views/img/subasta.jpg'),
('Financiación', '/Fashe/views/img/financiacion.jpg');

-- Colores
INSERT INTO colores (name, image) VALUES 
('Negro', '/Fashe/views/img/negro.jpg'),
('Dorado', '/Fashe/views/img/dorado.jpg'),
('Plata', '/Fashe/views/img/plata.jpg'),
('Rojo', '/Fashe/views/img/rojo.jpg'),
('Azul', '/Fashe/views/img/azul.jpg');

-- Materiales
INSERT INTO materiales (name, image) VALUES 
('Metal', '/Fashe/views/img/metal.jpg'),
('Cuero', '/Fashe/views/img/cuero.jpg'),
('Plástico', '/Fashe/views/img/plastico.jpg');



-- Imágenes de accesorios
INSERT INTO imagenes_accesorios (name, image, id_accesorio) VALUES 
('Frontal Ray-Ban Aviator', '/Fashe/views/img/aviator_frontal.jpg', 1),
('Vista lateral Oakley Holbrook', '/Fashe/views/img/holbrook_lateral.jpg', 2),
('Vista trasera Rolex Submariner', '/Fashe/views/img/rolex_lateral.jpg', 3),
('Casio G-Shock en la muñeca', '/Fashe/views/img/gshock_muneca.jpg', 4),
('Mochila Nike Air en acción', '/Fashe/views/img/air_backpack_accion.jpg', 5),
('Interior de la mochila Adidas', '/Fashe/views/img/classic_backpack_interior.jpg', 6),
('Detalle del collar Gucci', '/Fashe/views/img/gg_marmont_detalle.jpg', 7),
('Louis Vuitton Chain en modelo', '/Fashe/views/img/lv_chain_modelo.jpg', 8);


-- Accesorios - Categorías
INSERT INTO accesorios_categorias (id_accesorio, id_categoria) VALUES 
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(7, 4),
(8, 4);

-- Accesorios - Tipos
INSERT INTO accesorios_tipos (id_accesorio, id_tipo) VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 2),
(5, 1),
(6, 2),
(7, 3),
(8, 3);

-- Accesorios - Tipos de Venta
INSERT INTO accesorios_tipos_venta (id_accesorio, id_tipo_venta) VALUES 
(1, 1),
(2, 1),
(3, 3),
(4, 1),
(5, 2),
(7, 3);
