

CREATE TABLE ciudades (
  id_ciudad INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE marcas (
  id_marca INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE modelos (
  id_modelo INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_marca INT
);

CREATE TABLE estados (
  id_estado INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE categorias (
  id_categoria INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE tipos (
  id_tipo INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE tipos_venta (
  id_tipo_venta INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE colores (
  id_color INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE materiales (
  id_material INT,
  name VARCHAR(100),
  image VARCHAR(255)
);

CREATE TABLE productos (
  id_producto INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_modelo INT,
  id_estado INT,
  id_ciudad INT,
  descripcion TEXT,
  precio DECIMAL(10,2)
);

CREATE TABLE imagenes_productos (
  id_imagen_producto INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_producto INT,
  url_imagen VARCHAR(255)
);

CREATE TABLE productos_categorias (
  id_productos_categorias INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_producto INT,
  id_categoria INT
);

CREATE TABLE productos_tipos (
  id_productos_tipos INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_producto INT,
  id_tipo INT
);


CREATE TABLE productos_tipos_venta (
  id_productos_tipos_venta INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_producto INT,
  id_tipo_venta INT
);


CREATE TABLE productos_colores (
  id_productos_colores INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_producto INT,
  id_color INT
);

CREATE TABLE productos_materiales (
  id_productos_materiales INT,
  name VARCHAR(100),
  image VARCHAR(255),
  id_producto INT,
  id_material INT
);


--Restricicones

ALTER TABLE ciudades
  MODIFY id_ciudad INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_ciudad);


ALTER TABLE marcas
  MODIFY id_marca INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_marca);


ALTER TABLE modelos
  MODIFY id_modelo INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_modelo),
  ADD CONSTRAINT fk_modelos_marca
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca);

ALTER TABLE estados
  MODIFY id_estado INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_estado);

ALTER TABLE categorias
  MODIFY id_categoria INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_categoria);

ALTER TABLE tipos
  MODIFY id_tipo INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_tipo);

ALTER TABLE tipos_venta
  MODIFY id_tipo_venta INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_tipo_venta);

ALTER TABLE colores
  MODIFY id_color INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_color);

ALTER TABLE materiales
  MODIFY id_material INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_material);

ALTER TABLE productos
  MODIFY id_producto INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_producto),
  ADD CONSTRAINT fk_productos_modelo  FOREIGN KEY (id_modelo) REFERENCES modelos(id_modelo),
  ADD CONSTRAINT fk_productos_estado  FOREIGN KEY (id_estado) REFERENCES estados(id_estado),
  ADD CONSTRAINT fk_productos_ciudad FOREIGN KEY (id_ciudad) REFERENCES ciudades(id_ciudad);

ALTER TABLE imagenes_productos
  MODIFY id_imagen_producto INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_imagen_producto),
  ADD CONSTRAINT fk_imgprod_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto);

ALTER TABLE productos_categorias
  MODIFY id_productos_categorias INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_productos_categorias),
  ADD CONSTRAINT fk_prodcat_producto  FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  ADD CONSTRAINT fk_prodcat_categoria FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria);

ALTER TABLE productos_tipos
  MODIFY id_productos_tipos INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_productos_tipos),
  ADD CONSTRAINT fk_prodtipo_producto  FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  ADD CONSTRAINT fk_prodtipo_tipo FOREIGN KEY (id_tipo) REFERENCES tipos(id_tipo);

ALTER TABLE productos_tipos_venta
  MODIFY id_productos_tipos_venta INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_productos_tipos_venta),
  ADD CONSTRAINT fk_prodtipoventa_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  ADD CONSTRAINT fk_prodtipoventa_tipoventa  FOREIGN KEY (id_tipo_venta) REFERENCES tipos_venta(id_tipo_venta);


ALTER TABLE productos_colores
  MODIFY id_productos_colores INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_productos_colores),
  ADD CONSTRAINT fk_prodcol_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  ADD CONSTRAINT fk_prodcol_color FOREIGN KEY (id_color) REFERENCES colores(id_color);


ALTER TABLE productos_materiales
  MODIFY id_productos_materiales INT AUTO_INCREMENT,
  ADD PRIMARY KEY (id_productos_materiales),
  ADD CONSTRAINT fk_prodmat_producto FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
  ADD CONSTRAINT fk_prodmat_material FOREIGN KEY (id_material) REFERENCES materiales(id_material);





--inser into: 
-- Ciudades
INSERT INTO ciudades (name, image) VALUES 
('Madrid', 'madrid.jpg'),
('Barcelona', 'barcelona.jpg'),
('Valencia', 'valencia.jpg');

-- Marcas
INSERT INTO marcas (name, image) VALUES 
('Toyota', 'toyota.jpg'),
('Ford', 'ford.jpg'),
('BMW', 'bmw.jpg');

-- Modelos
INSERT INTO modelos (name, image, id_marca) VALUES 
('Corolla', 'corolla.jpg', 1),
('Focus', 'focus.jpg', 2),
('X5', 'x5.jpg', 3);

-- Estados
INSERT INTO estados (name, image) VALUES 
('Nuevo', 'nuevo.jpg'),
('Usado', 'usado.jpg'),
('Reacondicionado', 'reacondicionado.jpg');

-- Categorías
INSERT INTO categorias (name, image) VALUES 
('Coches', 'coches.jpg'),
('Motos', 'motos.jpg'),
('Camiones', 'camiones.jpg');

-- Tipos
INSERT INTO tipos (name, image) VALUES 
('Sedán', 'sedan.jpg'),
('SUV', 'suv.jpg'),
('Hatchback', 'hatchback.jpg');

-- Tipos de venta
INSERT INTO tipos_venta (name, image) VALUES 
('Venta directa', 'venta_directa.jpg'),
('Subasta', 'subasta.jpg'),
('Financiación', 'financiacion.jpg');

-- Colores
INSERT INTO colores (name, image) VALUES 
('Rojo', 'rojo.jpg'),
('Azul', 'azul.jpg'),
('Negro', 'negro.jpg');

-- Materiales
INSERT INTO materiales (name, image) VALUES 
('Acero', 'acero.jpg'),
('Aluminio', 'aluminio.jpg'),
('Fibra de carbono', 'fibra_carbono.jpg');

-- Productos
INSERT INTO productos (name, image, id_modelo, id_estado, id_ciudad, descripcion, precio) VALUES 
('Toyota Corolla 2022', 'toyota_corolla_2022.jpg', 1, 1, 1, 'Toyota Corolla en perfecto estado, poco uso.', 20000.00),
('Ford Focus 2019', 'ford_focus_2019.jpg', 2, 2, 2, 'Ford Focus con mantenimiento reciente, motor eficiente.', 15000.00),
('BMW X5 2021', 'bmw_x5_2021.jpg', 3, 1, 3, 'BMW X5 con paquete premium, interiores de lujo.', 50000.00);

-- Imágenes de productos
INSERT INTO imagenes_productos (name, image, id_producto, url_imagen) VALUES 
('Vista frontal', 'toyota_corolla_frontal.jpg', 1, 'https://example.com/toyota_frontal.jpg'),
('Vista trasera', 'ford_focus_trasero.jpg', 2, 'https://example.com/ford_trasero.jpg'),
('Interior de lujo', 'bmw_x5_interior.jpg', 3, 'https://example.com/bmw_interior.jpg');

-- Productos - Categorías
INSERT INTO productos_categorias (name, image, id_producto, id_categoria) VALUES 
('Toyota Corolla - Coches', 'toyota_categoria.jpg', 1, 1),
('Ford Focus - Coches', 'ford_categoria.jpg', 2, 1),
('BMW X5 - SUVs', 'bmw_categoria.jpg', 3, 1);

-- Productos - Tipos
INSERT INTO productos_tipos (name, image, id_producto, id_tipo) VALUES 
('Toyota Corolla - Sedán', 'toyota_sedan.jpg', 1, 1),
('Ford Focus - Hatchback', 'ford_hatchback.jpg', 2, 3),
('BMW X5 - SUV', 'bmw_suv.jpg', 3, 2);

-- Productos - Tipos de Venta
INSERT INTO productos_tipos_venta (name, image, id_producto, id_tipo_venta) VALUES 
('Toyota Corolla - Venta directa', 'toyota_venta_directa.jpg', 1, 1),
('Ford Focus - Financiación', 'ford_financiacion.jpg', 2, 3),
('BMW X5 - Subasta', 'bmw_subasta.jpg', 3, 2);

-- Productos - Colores
INSERT INTO productos_colores (name, image, id_producto, id_color) VALUES 
('Toyota Corolla - Rojo', 'toyota_rojo.jpg', 1, 1),
('Ford Focus - Azul', 'ford_azul.jpg', 2, 2),
('BMW X5 - Negro', 'bmw_negro.jpg', 3, 3);

-- Productos - Materiales
INSERT INTO productos_materiales (name, image, id_producto, id_material) VALUES 
('Toyota Corolla - Acero', 'toyota_acero.jpg', 1, 1),
('Ford Focus - Aluminio', 'ford_aluminio.jpg', 2, 2),
('BMW X5 - Fibra de carbono', 'bmw_fibra_carbono.jpg', 3, 3);
