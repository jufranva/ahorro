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
  link VARCHAR(255) NOT NULL DEFAULT 'shop-grid.html'
);
INSERT INTO banners (title, subtitle, image, link) VALUES
('Office Dress', 'Up to 50% Off', 'assets/images/banner/banner-4.jpg', 'shop-grid.html'),
('All Products', 'Up to 40% Off', 'assets/images/banner/banner-5.jpg', 'shop-grid.html');
