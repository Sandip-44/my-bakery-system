-- Database: bakery_db
    CREATE DATABASE IF NOT EXISTS bakery_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    USE bakery_db;

    CREATE TABLE IF NOT EXISTS admin_users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    INSERT INTO admin_users (username, password) VALUES
    ('admin', '$2y$10$u1K7kGqfQ9q8b6p5rWzZ6uE8wQeY2pTq2jVQG4o6b9cD0eF1a2B3'); -- password: admin123 (hashed)

    CREATE TABLE IF NOT EXISTS products (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(150) NOT NULL,
      description TEXT,
      price DECIMAL(10,2) DEFAULT 0.00,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    INSERT INTO products (name, description, price) VALUES
    ('Classic Sourdough', 'Crispy crust, soft center.', 5.50),
    ('Chocolate Croissant', 'Butter flaky croissant with chocolate.', 3.25),
    ('Blueberry Muffin', 'Fresh blueberries in a soft muffin.', 2.75);
