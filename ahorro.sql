CREATE DATABASE IF NOT EXISTS ahorro;
USE ahorro;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  role INT NOT NULL,
  password VARCHAR(255) NOT NULL
);
INSERT INTO users (username, name, role, password) VALUES ('admin', 'Administrador', 1, '$2y$12$ezA0Ov0KAUW5PpyPoG6urOnu1B7vKes0onxl4huXVdhIJIW/9HmH.');

CREATE TABLE IF NOT EXISTS slides (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL DEFAULT 'index.php',
  estado TINYINT NOT NULL DEFAULT 1,
  color TINYINT NOT NULL DEFAULT 1
);
INSERT INTO slides (title, description, image, link, estado, color) VALUES
('Women New Collection', 'Up to 70% off selected Product', 'assets/images/slider/slide-1.jpg', 'shop-grid.html', 1, 1);

CREATE TABLE IF NOT EXISTS banners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  subtitle VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL DEFAULT 'shop-grid.html',
  color TINYINT NOT NULL DEFAULT 1
);
INSERT INTO banners (title, subtitle, image, link, color) VALUES
('Office Dress', 'Up to 50% Off', 'assets/images/banner/banner-4.jpg', 'shop-grid.html', 1),
('All Products', 'Up to 40% Off', 'assets/images/banner/banner-5.jpg', 'shop-grid.html', 1);

CREATE TABLE IF NOT EXISTS features (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  icon VARCHAR(255) NOT NULL
);
INSERT INTO features (title, description, icon) VALUES
('Envios (10 USD)', 'a todo el ECUADOR\npor SERIENTREGA', 'assets/images/icons/feature-icon-2.png'),
('Aceptamos pagos', 'Efectivo, Transferencia o Tarjetas', 'assets/images/icons/feature-icon-4.png'),
('Descuentos especiales', 'En nuestors en vivos de TIK TOK', 'assets/images/icons/feature-icon-1.png');

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS providers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  text VARCHAR(100) NOT NULL,
  color ENUM('amarillo','azul','rojo','verde') NOT NULL
);

CREATE TABLE IF NOT EXISTS states (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS garments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  image_primary VARCHAR(255) NOT NULL,
  image_secondary VARCHAR(255) DEFAULT NULL,
  purchase_value DECIMAL(10,2) NOT NULL,
  sale_value DECIMAL(10,2) NOT NULL,
  unique_code VARCHAR(100) NOT NULL,
  `condition` TINYINT NOT NULL,
  size VARCHAR(20) NOT NULL,
  comment VARCHAR(200) NOT NULL,
  type ENUM('nueva','usada') NOT NULL,
  category_id INT,
  provider_id INT,
  tag_id INT,
  state_id INT,
  purchase_date DATE,
  sale_date DATE,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (provider_id) REFERENCES providers(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id),
  FOREIGN KEY (state_id) REFERENCES states(id)
);

CREATE TABLE IF NOT EXISTS cart_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  session_id VARCHAR(64) NOT NULL,
  garment_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_cart (session_id, garment_id),
  FOREIGN KEY (garment_id) REFERENCES garments(id) ON DELETE CASCADE
);

DROP TRIGGER IF EXISTS cart_item_after_delete;
DELIMITER //
CREATE TRIGGER cart_item_after_delete
AFTER DELETE ON cart_items
FOR EACH ROW
BEGIN
  IF (SELECT COUNT(*) FROM cart_items WHERE garment_id = OLD.garment_id) = 0 THEN
    UPDATE garments SET tag_id = NULL WHERE id = OLD.garment_id;
  END IF;
END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS credits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  value DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS credit_contributions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  credit_id INT NOT NULL,
  order_id INT NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  contributed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (credit_id) REFERENCES credits(id) ON DELETE CASCADE,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  buyer_name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  payment_method VARCHAR(20) NOT NULL,
  credit_id INT DEFAULT NULL,
  entregado TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('pending','confirmed','credit','paid','delivered','rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (credit_id) REFERENCES credits(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  garment_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (garment_id) REFERENCES garments(id)
);
