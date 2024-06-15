

E-commerce Website with php for the back end and javascript html  and css for the frontend 
Certainly! Here's an updated README.md file that includes information about the admin functionalities:
![Screenshot (9)](https://github.com/codewithdann0/e-commerce/assets/166249731/678de520-f463-4ed2-9285-654f34e01b62)
![Screenshot (10)](https://github.com/codewithdann0/e-commerce/assets/166249731/d0ee5cd1-af5d-4fd2-9c2d-e60bd726a2b6)
![Screenshot (11)](https://github.com/codewithdann0/e-commerce/assets/166249731/39cd686b-89e9-496b-90d4-731f0eb4185a)
![Screenshot (12)](https://github.com/codewithdann0/e-commerce/assets/166249731/13d74d89-1814-4c6b-86fa-49bab165ff42)

markdown
Copy code
# E-Commerce Project

This is a simple e-commerce web application built with PHP and MySQL. It allows users to register, login, place orders, and view order details. The project is designed to demonstrate basic CRUD operations, user authentication, and session management. Additionally, there is an admin role with special privileges.

## Features

- User Registration and Login
- Product Listing
- Place Orders
- View Order Details
- User Profile Management
- Admin Dashboard
- Add Products
- Delete Users- View Orders
- Logout

## Technologies Used

- PHP
- MySQL
- HTML/CSS
- JavaScript
- Bootstrap (optional, for styling)
- XAMPP (or any other local server environment)

## Project Structure

e-commerce/

## how to create the Database and Tables with my sql syntax 
-- Create database if not exists
CREATE DATABASE IF NOT EXISTS ecommerce;

-- Use the database
USE ecommerce;

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: `order`
CREATE TABLE `order` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_cost DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table: order_details
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    order_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (order_id) REFERENCES `order`(id)
);
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
