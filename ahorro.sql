CREATE DATABASE IF NOT EXISTS ahorro;
USE ahorro;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);
INSERT INTO users (username, password) VALUES ('admin', '$2y$12$ezA0Ov0KAUW5PpyPoG6urOnu1B7vKes0onxl4huXVdhIJIW/9HmH.');

CREATE TABLE IF NOT EXISTS slides (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL DEFAULT 'index.php'
);
INSERT INTO slides (title, description, image, link) VALUES
('Women New Collection', 'Up to 70% off selected Product', 'assets/images/slider/slide-1.jpg', 'shop-grid.html');
