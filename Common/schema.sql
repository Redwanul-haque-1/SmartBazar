-- SQL schema for SmartBazar
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(30),
  address TEXT,
  gender ENUM('Male','Female','Other') NOT NULL,
  dob DATE,
  profile_image VARCHAR(255),
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('Admin','Seller','Customer') NOT NULL,
  status ENUM('Pending','Approved','Blocked') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Additional tables to be extended later
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seller_id INT NOT NULL,
  category_id INT,
  name VARCHAR(100),
  description TEXT,
  price DECIMAL(10,2),
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  total DECIMAL(10,2),
  status VARCHAR(30) DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL
);

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  customer_id INT NOT NULL,
  rating INT NOT NULL,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reported_by INT NOT NULL,
  product_id INT,
  seller_id INT,
  reason TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
