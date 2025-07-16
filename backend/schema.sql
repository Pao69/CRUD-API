-- Create the database
CREATE DATABASE IF NOT EXISTS car_dealership;
USE car_dealership;

-- Create the cars table
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add some sample data
INSERT INTO cars (make, model, year, price, description) VALUES
    ('Toyota', 'Camry', 2022, 25000.00, 'Reliable mid-size sedan with great fuel economy'),
    ('Honda', 'Civic', 2023, 22000.00, 'Compact car with modern features'),
    ('Ford', 'Mustang', 2021, 35000.00, 'Classic American muscle car'); 