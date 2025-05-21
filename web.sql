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
  id_imagen VARCHAR(255),
  id_modelo INT,
  id_estado INT,
  id_ciudad INT,
  id_marca INT,
  id_categoria INT,
  descripcion TEXT,
  descripcion_larga TEXT,
  precio DECIMAL(10,2),
  lat DECIMAL(9,6),
  lon DECIMAL(9,6),
  popular INT,
  rating INT,
  FOREIGN KEY (id_modelo) REFERENCES modelos(id_modelo),
  FOREIGN KEY (id_estado) REFERENCES estados(id_estado),
  FOREIGN KEY (id_ciudad) REFERENCES ciudades(id_ciudad),
  FOREIGN KEY (id_marca) REFERENCES marcas(id_marca),
  FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);


CREATE TABLE marcas (
  id_marca INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);


CREATE TABLE complementos (
  id_complemento INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  image VARCHAR(255)
);

INSERT INTO complementos( name, image) VALUES 
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Cristales', '/Fashe/views/img/gafas.jpg'),
('Reloj', '/Fashe/views/img/relojes.jpg'),
('Mochila', '/Fashe/views/img/mochilas.jpg'),
('Collar', '/Fashe/views/img/collares.jpg'),
('Tecnología', '/Fashe/views/img/tecnologia.jpg');
 
CREATE TABLE accesorios_complemento ( 
  id_accesorio INT,
  id_complemento INT,
  PRIMARY KEY (id_accesorio, id_complemento),
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_complemento) REFERENCES complementos(id_complemento)
);

INSERT INTO accesorios_complemento (id_accesorio, id_complemento) VALUES 
(1, 1), -- Ray-Ban Aviator -> Cristales
(1, 2), -- Oakley Holbrook -> Cristales
(1, 3), -- Rolex Submariner -> Reloj
(1, 4), -- Casio G-Shock -> Reloj
(1, 5), -- Nike Air Backpack -> Mochila
(1, 6), -- Adidas Classic Backpack -> Mochila
(1, 7), -- Gucci GG Marmont -> Collar
(1, 8), -- Louis Vuitton Chain -> Collar
(1, 9), -- Persol PO0714 -> Cristales
(1, 10), -- Prada Linea Rossa -> Cristales
(1, 11), -- Tom Ford FT0237 -> Cristales
(1, 12), -- Maui Jim Peahi -> Cristales
(1, 13); -- Carrera Champion -> Cristales

INSERT INTO accesorios (name, id_imagen, id_modelo, id_estado, id_ciudad, id_marca, id_categoria, descripcion, descripcion_larga, precio, lat, lon, popular, rating) VALUES
('Ray-Ban Aviator', 1, 1, 1, 1, 1, 1, 'Gafas de sol clásicas Ray-Ban Aviator en color negro.', 'Las Ray-Ban Aviator son un clásico atemporal en el mundo de las gafas de sol...', 120.00, 40.418500, -3.703100, 9, 1),
('Oakley Holbrook', 2, 2, 1, 2, 2, 1, 'Gafas de sol Oakley Holbrook con protección UV.', 'Las Oakley Holbrook combinan un diseño clásico con tecnología moderna...', 95.00, 41.385200, 2.173800, 8, 1),
('Rolex Submariner', 3, 3, 2, 3, 3, 2, 'Reloj Rolex Submariner en excelente estado.', 'El Rolex Submariner es un reloj icónico...', 8500.00, 39.470800, -0.375900, 10, 1),
('Casio G-Shock', 4, 4, 1, 4, 4, 2, 'Reloj deportivo Casio G-Shock resistente al agua.', 'El Casio G-Shock es el reloj definitivo en términos de durabilidad...', 120.00, 37.388000, -5.982100, 7, 1),
('Nike Air Backpack', 5, 5, 1, 5, 5, 3, 'Mochila deportiva Nike Air con amplio almacenamiento.', 'La Nike Air Backpack es la combinación perfecta entre estilo y funcionalidad...', 60.00, 43.264900, -2.933000, 6, 1),
('Adidas Classic Backpack', 6, 6, 1, 6, 6, 3, 'Mochila Adidas de estilo casual.', 'La mochila Adidas Classic combina un diseño urbano con la funcionalidad...', 45.00, 36.720200, -4.419000, 6, 1),
('Gucci GG Marmont', 7, 7, 1, 1, 7, 4, 'Collar Gucci GG Marmont con cadena de oro.', 'El collar Gucci GG Marmont es una pieza de lujo exquisita...', 1500.00, 40.415300, -3.706500, 9, 1),
('Louis Vuitton Chain', 8, 8, 1, 2, 8, 4, 'Collar Louis Vuitton con detalles exclusivos.', 'Este collar Louis Vuitton representa la fusión perfecta entre la artesanía...', 2200.00, 41.389800, 2.165000, 9, 1),
('Persol PO0714', 9, 9, 1, 3, 9, 1, 'Gafas de sol Persol PO0714 plegables en color habana.', 'Las Persol PO0714 son un modelo icónico con un diseño plegable...', 210.00, 39.467200, -0.379800, 7, 1),
('Prada Linea Rossa', 10, 10, 1, 4, 10, 1, 'Gafas de sol Prada Linea Rossa con montura de fibra de carbono.', 'Las Prada Linea Rossa destacan por su diseño moderno y vanguardista...', 280.00, 37.391100, -5.985700, 8, 1),
('Tom Ford FT0237', 11, 11, 1, 5, 11, 1, 'Gafas de sol Tom Ford FT0237 en negro mate.', 'Las Tom Ford FT0237 representan el lujo y la exclusividad...', 350.00, 43.261000, -2.937500, 8, 1),
('Maui Jim Peahi', 12, 12, 1, 6, 12, 1, 'Gafas de sol polarizadas Maui Jim Peahi para alta protección.', 'Las Maui Jim Peahi están diseñadas para ofrecer la mejor experiencia visual...', 250.00, 36.722700, -4.423200, 7, 1),
('Carrera Champion', 13, 13, 1, 1, 13, 1, 'Gafas de sol Carrera Champion con diseño icónico.', 'Las Carrera Champion son un modelo clásico y atemporal...', 120.00, 40.417600, -3.701200, 8, 1),
('Polaroid PLD 2053/S', 9, 9, 1, 3, 9, 1, 'Gafas de sol Polaroid PLD 2053/S con lentes polarizadas.', 'Las Polaroid PLD 2053/S ofrecen una protección óptima con un diseño moderno y versátil...', 75.00, 41.386800, 2.170000, 6, 1),
('Arnette AN4202 Fastball', 9, 9, 1, 3, 9, 1, 'Gafas de sol Arnette AN4202 ideales para un estilo urbano.', 'Las Arnette Fastball combinan durabilidad y estilo juvenil, perfectas para el día a día...', 85.00, 43.263200, -2.934000, 6, 1),
('Hawkers Carbon Black Sky', 9, 9, 1, 3, 9, 1, 'Gafas de sol Hawkers Carbon Black Sky con diseño ligero.', 'Las Hawkers Carbon Black Sky destacan por su ligereza, resistencia y estética minimalista...', 40.00, 36.719500, -4.421000, 5, 2),
('Vogue VO2843S', 9, 9, 1, 3, 9, 1, 'Gafas de sol Vogue VO2843S para mujer en color burdeos.', 'Las Vogue VO2843S destacan por su estilo elegante y moderno, ideales para completar cualquier look veraniego.', 95.00, 39.468800, -0.376500, 7, 1),
('Diesel DL0174', 9, 9, 1, 3, 9, 1, 'Gafas de sol Diesel DL0174 con montura robusta.', 'Las Diesel DL0174 ofrecen un diseño audaz para quienes buscan destacar con estilo y personalidad.', 110.00, 37.389900, -5.983800, 6, 1),
('Burberry BE4216', 9, 9, 1, 3, 9, 1, 'Gafas de sol Burberry BE4216 con detalles en las patillas.', 'Las Burberry BE4216 combinan la elegancia británica con un diseño contemporáneo, perfectas para el día a día.', 180.00, 40.416000, -3.703900, 8, 3),
('Emporio Armani EA4035', 9, 9, 1, 3, 9, 1, 'Gafas de sol Emporio Armani EA4035 deportivas.', 'Las EA4035 de Emporio Armani son ideales para un estilo deportivo sin perder la sofisticación.', 130.00, 41.384000, 2.171900, 7, 2),
('Guess GU7559', 9, 9, 1, 3, 9, 1, 'Gafas de sol Guess GU7559 con estilo glamuroso.', 'Las Guess GU7559 están diseñadas para ofrecer glamour y protección en cualquier ocasión.', 105.00, 36.721000, -4.420000, 6, 1);


CREATE TABLE accesorios_extras (
  id_accesorio INT,
  id_extra INT,
  PRIMARY KEY (id_accesorio, id_extra),
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  FOREIGN KEY (id_extra) REFERENCES extras(id_extra)
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
  image VARCHAR(255),
  visitado INT
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


CREATE TABLE extras (
  id_extra INT AUTO_INCREMENT PRIMARY KEY,
  id_accesorio INT,
  icono VARCHAR(255),
  titulo VARCHAR(100),
  descripcion VARCHAR(255),
  FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio)
);


CREATE TABLE imagenes (
  id_imagen INT AUTO_INCREMENT PRIMARY KEY,
  id_producto INT,
  image VARCHAR(255),
  FOREIGN KEY (id_producto) REFERENCES accesorios(id_accesorio)
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

CREATE TABLE likes (
  id_like      INT AUTO_INCREMENT PRIMARY KEY,
  id_accesorio INT NOT NULL,
  correo       VARCHAR(191) NOT NULL,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_like (id_accesorio, correo),
  CONSTRAINT fk_likes_accesorio
    FOREIGN KEY (id_accesorio) REFERENCES accesorios(id_accesorio),
  CONSTRAINT fk_likes_usuario_correo
    FOREIGN KEY (correo)       REFERENCES usuarios(correo)
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

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    tipo VARCHAR(50) DEFAULT 'cliente',
    avatar VARCHAR(255) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 0,
    token_email VARCHAR(255) DEFAULT NULL
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
('Ray-Ban', '/Fashe/views/img/rayban.jpg'),
('Oakley', '/Fashe/views/img/oakley.webp'),
('Rolex', '/Fashe/views/img/rolex.jpg'),
('Casio', '/Fashe/views/img/casio.jpg'),
('Nike', '/Fashe/views/img/nike.jpg'),
('Adidas', '/Fashe/views/img/adidas.jpg'),
('Gucci', '/Fashe/views/img/gucci.jpg'),
('Louis Vuitton', '/Fashe/views/img/lv.jpg'),
('Persol', '/Fashe/views/img/persol.jpg'),
('Prada', '/Fashe/views/img/prada.jpg'),
('Tom Ford', '/Fashe/views/img/tomford.jpg'),
('Maui Jim', '/Fashe/views/img/mauijim.jpg'),
('Carrera', '/Fashe/views/img/carrera.jpg');



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


-- Modelos
INSERT INTO modelos (name, image, id_marca) VALUES 
('Aviator', '/Fashe/views/img/aviator.jpg', 1),
('Holbrook', '/Fashe/views/img/holbrook.jpg', 2),
('Submariner', '/Fashe/views/img/submariner.jpg', 3),
('G-Shock', '/Fashe/views/img/gshock.jpg', 4),
('Air Backpack', '/Fashe/views/img/air_backpack.jpg', 5),
('Classic Backpack', '/Fashe/views/img/classic_backpack.jpg', 6),
('GG Marmont', '/Fashe/views/img/gg_marmont.jpg', 7),
('LV Chain', '/Fashe/views/img/lv_chain.jpg', 8),
('PO0714', '/Fashe/views/img/persol_0714.jpg', 9),
('Linea Rossa', '/Fashe/views/img/prada_linea_rossa.jpg', 10),
('FT0237', '/Fashe/views/img/tomford_ft0237.jpg', 11),
('Peahi', '/Fashe/views/img/maui_jim_peahi.jpg', 12),
('Champion', '/Fashe/views/img/carrera_champion.jpg', 13);

-- Estados
INSERT INTO estados (name, image) VALUES 
('Nuevo', '/Fashe/views/img/nuevo.jpg'),
('Usado', '/Fashe/views/img/usado.jpg'),
('Reacondicionado', '/Fashe/views/img/reacondicionado.jpg');

-- Categorías
INSERT INTO categorias (name, image, visitado) VALUES 
('Gafas de sol', '/Fashe/views/img/gafas.jpg', 1),
('Relojes', '/Fashe/views/img/relojes.jpg', 2),
('Mochilas', '/Fashe/views/img/mochilas.jpg', 3),
('Collares', '/Fashe/views/img/collares.jpg', 4),
('Tecnología', '/Fashe/views/img/tecnologia.jpg', 2),
('Ropa', '/Fashe/views/img/ropa.jpg', 3),
('Cara', '/Fashe/views/img/cara.jpg', 4);
 






INSERT INTO usuarios (nombre, correo, contraseña, tipo, avatar,activo,token_email)
VALUES (
    'alex',
    'alex@gmail.com',
    '1234',
    'cliente',
    'https://api.dicebear.com/7.x/adventurer/svg?seed=alex',
    1,
    'token_email'
);



-- Inserciones en la tabla imagenes
INSERT INTO imagenes (id_producto, image) VALUES
(1, '/Fashe/views/img/aviator_negro.webp'),
(1, '/Fashe/views/img/aviator_frontal.jpg'),
(2, '/Fashe/views/img/holbrook_azul.jpg'),
(2, '/Fashe/views/img/oakley_2.webp'),
(2, '/Fashe/views/img/oakley_3.webp'),
(3, '/Fashe/views/img/rolex_submariner.jpg'),
(3, '/Fashe/views/img/rolex_lateral.jpg'),
(4, '/Fashe/views/img/gshock_rojo.webp'),
(4, '/Fashe/views/img/gshock_muneca.jpg'),
(5, '/Fashe/views/img/air_backpack.jpg'),
(5, '/Fashe/views/img/air_backpack_accion.jpg'),
(6, '/Fashe/views/img/classic_backpack.jpg'),
(6, '/Fashe/views/img/classic_backpack_interior.jpg'),
(7, '/Fashe/views/img/gg_marmont.webp'),
(7, '/Fashe/views/img/gg_marmont_detalle.jpg'),
(8, '/Fashe/views/img/lv_chain.jpg'),
(8, '/Fashe/views/img/lv_chain_modelo.jpg'),
(9, '/Fashe/views/img/persol_0714_frontal.avif'),
(9, '/Fashe/views/img/persol_0714_lateral.avif'),
(9, '/Fashe/views/img/persol_0714_plegadas.avif'),
(9, '/Fashe/views/img/persol_0714_modelo.avif'),
(10, '/Fashe/views/img/prada_linea_rossa_frontal.jpg'),
(10, '/Fashe/views/img/prada_linea_rossa_lateral.jpg'),
(10, '/Fashe/views/img/prada_linea_rossa_caja.jpg'),
(10, '/Fashe/views/img/prada_linea_rossa_modelo.jpg'),
(11, '/Fashe/views/img/tomford_ft0237_frontal.webp'),
(11, '/Fashe/views/img/tomford_ft0237_lateral.webp'),
(11, '/Fashe/views/img/tomford_ft0237_detalle.webp'),
(12, '/Fashe/views/img/maui_jim_peahi_frontal.webp'),
(12, '/Fashe/views/img/maui_jim_peahi_lateral.webp'),
(12, '/Fashe/views/img/maui_jim_peahi_detalle.jpg'),
(12, '/Fashe/views/img/maui_jim_peahi_modelo.webp'),
(13, '/Fashe/views/img/carrera_champion_frontal.webp'),
(13, '/Fashe/views/img/carrera_champion_lateral.webp'),
(13, '/Fashe/views/img/carrera_champion_detalle.webp');


INSERT INTO extras (id_accesorio, icono, titulo, descripcion) VALUES
(1, 'fa-solid fa-truck-fast', 'Entrega Rápida', 'Recibe tu pedido en tiempo récord.'),
(2, 'fa-solid fa-lock', 'Pago Seguro', 'Métodos de pago protegidos y confiables.'),
(3, 'fa-solid fa-headset', 'Atención 24/7', 'Soporte al cliente en cualquier momento.'),
(4, 'fa-solid fa-rotate-left', 'Devolución Gratuita', 'Devolución sin costo en caso de problemas.'),
(5, 'fa-solid fa-badge-check', 'Garantía de Calidad', 'Productos verificados y certificados.'),
(6, 'fa-solid fa-tags', 'Ofertas Especiales', 'Descuentos exclusivos en productos seleccionados.'),
(7, 'fa-solid fa-boxes-stacked', 'Variedad de Productos', 'Amplia gama de artículos disponibles.'),
(8, 'fa-solid fa-language', 'Soporte Multilingüe', 'Atención en varios idiomas para mayor comodidad.'),
(9, 'fa-solid fa-store', 'Tienda Física', 'Visítanos en nuestra tienda física más cercana.'),
(10, 'fa-solid fa-star', 'Novedades', 'Descubre los últimos lanzamientos y tendencias.'),
(11, 'fa-solid fa-gift', 'Regalos Especiales', 'Opciones perfectas para sorprender a alguien.'),
(12, 'fa-solid fa-shield-alt', 'Protección de Datos', 'Tus datos personales están seguros con nosotros.'),
(13, 'fa-solid fa-thumbs-up', 'Productos Recomendados', 'Artículos con las mejores valoraciones.'),
(14, 'fa-solid fa-credit-card', 'Múltiples Métodos de Pago', 'Diversas opciones de pago para tu comodidad.'),
(15, 'fa-solid fa-percent', 'Descuentos por Volumen', 'Compra más y paga menos con ofertas especiales.'),
(16, 'fa-solid fa-user-friends', 'Programa de Referidos', 'Recomienda amigos y gana recompensas.'),
(17, 'fa-solid fa-leaf', 'Productos Ecológicos', 'Opciones sostenibles para un mundo mejor.'),
(18, 'fa-solid fa-certificate', 'Certificación Autenticidad', 'Garantía de autenticidad en cada compra.'),
(19, 'fa-solid fa-wallet', 'Precios Competitivos', 'Encuentra los mejores precios del mercado.'),
(20, 'fa-solid fa-truck-loading', 'Envío Gratuito', 'Envío sin costo en pedidos superiores a cierto monto.');



-- Accesorios - Categorías (relación muchos a muchos)
INSERT INTO accesorios_categorias (id_accesorio, id_categoria) VALUES 
(1, 1), -- Ray-Ban Aviator -> Gafas de sol
(1, 6), -- Ray-Ban Aviator -> Ropa
(1, 7), -- Ray-Ban Aviator -> Cara
(2, 1), -- Oakley Holbrook -> Gafas de sol
(3, 2), -- Rolex Submariner -> Relojes
(4, 2), -- Casio G-Shock -> Relojes
(5, 3), -- Nike Air Backpack -> Mochilas
(6, 3), -- Adidas Classic Backpack -> Mochilas
(7, 4), -- Gucci GG Marmont -> Collares
(8, 4), -- Louis Vuitton Chain -> Collares
(9, 1), -- Persol PO0714 -> Gafas de sol
(10, 1), -- Prada Linea Rossa -> Gafas de sol
(11, 1), -- Tom Ford FT0237 -> Gafas de sol
(12, 1), -- Maui Jim Peahi -> Gafas de sol
(13, 1); -- Carrera Champion -> Gafas de sol

-- Accesorios - Extras (relación muchos a muchos)
INSERT INTO accesorios_extras (id_accesorio, id_extra) VALUES 
(1, 1), 
(1, 3), 
(1, 2), -- Ray-Ban Aviator -> Entrega rápida
(2, 2), -- Oakley Holbrook -> Pago seguro
(3, 3), -- Rolex Submariner -> Atención al Cliente 24/7
(4, 4), -- Casio G-Shock -> Devolución gratuita
(5, 5), -- Nike Air Backpack -> Garantía de calidad
(6, 6), -- Adidas Classic Backpack -> Ofertas especiales
(7, 7), -- Gucci GG Marmont -> Variedad de productos
(8, 8), -- Louis Vuitton Chain -> Soporte multilingüe
(9, 1), -- Persol PO0714 -> Entrega rápida
(10, 2), -- Prada Linea Rossa -> Pago seguro
(11, 3), -- Tom Ford FT0237 -> Atención al Cliente 24/7
(12, 4), -- Maui Jim Peahi -> Devolución gratuita
(13, 5); -- Carrera Champion -> Garantía de calidad


-- Accesorios - Tipos (relación muchos a muchos)
INSERT INTO accesorios_tipos (id_accesorio, id_tipo) VALUES 
(1, 1), -- Ray-Ban Aviator -> Casual
(2, 2), -- Oakley Holbrook -> Deportivo
(3, 3), -- Rolex Submariner -> Elegante
(4, 2), -- Casio G-Shock -> Deportivo
(5, 1), -- Nike Air Backpack -> Casual
(6, 2), -- Adidas Classic Backpack -> Deportivo
(7, 3), -- Gucci GG Marmont -> Elegante
(8, 3), -- Louis Vuitton Chain -> Elegante
(9, 2), -- Persol PO0714 -> Deportivo
(10, 3), -- Prada Linea Rossa -> Elegante
(11, 1), -- Tom Ford FT0237 -> Casual
(12, 2), -- Maui Jim Peahi -> Deportivo
(13, 3); -- Carrera Champion -> Elegante

-- Accesorios - Tipos de Venta (relación muchos a muchos)
INSERT INTO accesorios_tipos_venta (id_accesorio, id_tipo_venta) VALUES 
(1, 1), -- Ray-Ban Aviator -> Venta directa
(2, 1), -- Oakley Holbrook -> Venta directa
(3, 3), -- Rolex Submariner -> Financiación
(4, 1), -- Casio G-Shock -> Venta directa
(5, 2), -- Nike Air Backpack -> Subasta
(6, 2), -- Adidas Classic Backpack -> Subasta
(7, 3), -- Gucci GG Marmont -> Financiación
(8, 3), -- Louis Vuitton Chain -> Financiación
(9, 1), -- Persol PO0714 -> Venta directa
(10, 1), -- Prada Linea Rossa -> Venta directa
(11, 1), -- Tom Ford FT0237 -> Venta directa
(12, 2), -- Maui Jim Peahi -> Subasta
(13, 2); -- Carrera Champion -> Subasta


CREATE TABLE tipo_formato (
  id_tipo_formato INT AUTO_INCREMENT PRIMARY KEY,
  nombre_tabla VARCHAR(100) NOT NULL,
  tipo VARCHAR(50) NOT NULL 
);

INSERT INTO tipo_formato (nombre_tabla, tipo) VALUES
('categorias', 'select'),
('marcas', 'checkbox'),
('ciudades', 'select'),
('estados', 'select');



