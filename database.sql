CREATE DATABASE recharge_system;
USE recharge_system;

CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL
);

CREATE TABLE apps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE recharge_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    app_id INT NOT NULL,
    code VARCHAR(50) NOT NULL UNIQUE,
    is_used BOOLEAN DEFAULT 0,
    FOREIGN KEY (app_id) REFERENCES apps(id)
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    app_id INT NOT NULL,
    code_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (app_id) REFERENCES apps(id),
    FOREIGN KEY (code_id) REFERENCES recharge_codes(id)
);