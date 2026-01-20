CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(30),
  address TEXT,
  gender ENUM('Male','Female','Other') NOT NULL,
  dob DATE,
  profile_image VARCHAR(255),
  password_pass VARCHAR(255) NOT NULL,
  role ENUM('Admin','Seller','Customer') NOT NULL,
  status ENUM('Pending','Approved','Blocked') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

