CREATE DATABASE gt_menu;
USE gt_menu;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

CREATE TABLE menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  name VARCHAR(100),
  description TEXT,
  price DECIMAL(6,2),
  image VARCHAR(255),
  is_available TINYINT(1) DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT INTO categories (name) VALUES
('Popular'), ('Meals'), ('Drinks');
