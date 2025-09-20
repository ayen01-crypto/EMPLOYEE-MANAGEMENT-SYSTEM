-- Employee Management System Database Schema
-- Created by: Ayen Geoffrey Alexander
-- Registration Number: 2024/A/KCS/5102/G/F

CREATE DATABASE IF NOT EXISTS employee_management;
USE employee_management;

-- Employees table
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    department VARCHAR(50),
    position VARCHAR(50),
    salary DECIMAL(10,2),
    hire_date DATE,
    status ENUM('active', 'inactive', 'terminated') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Note: Departments are managed as ENUM values in the employees table
-- Available departments: Human Resources, Information Technology, Finance, Marketing, Operations

-- Insert sample employees (Salaries in UGX - minimum 1,000,000 UGX)
INSERT INTO employees (employee_id, first_name, last_name, email, phone, department, position, salary, hire_date, status) VALUES
('EMP001', 'Linnet', 'Kukunda', 'linnet.kukunda@company.com', '0701234567', 'Human Resources', 'HR Manager', 2200000.00, '2023-01-15', 'active'),
('EMP002', 'Eddie', 'Rukundo', 'eddie.rukundo@company.com', '0701234568', 'Information Technology', 'Software Developer', 2500000.00, '2022-06-01', 'active'),
('EMP003', 'Edrine', 'Kimuli', 'edrine.kimuli@company.com', '0701234569', 'Finance', 'Accountant', 1800000.00, '2023-03-10', 'active'),
('EMP004', 'Dianalh', 'Kyoshabire', 'dianalh.kyoshabire@company.com', '0701234570', 'Marketing', 'Marketing Specialist', 1500000.00, '2023-05-20', 'active'),
('EMP005', 'Brian', 'Kassozi', 'brian.kassozi@company.com', '0701234571', 'Operations', 'Operations Manager', 2300000.00, '2022-11-15', 'active'),
('EMP006', 'Savious', 'Kukundakwe', 'savious.kukundakwe@company.com', '0701234572', 'Information Technology', 'System Administrator', 2000000.00, '2023-02-10', 'active'),
('EMP007', 'Allan', 'Ainebyona', 'allan.ainebyona@company.com', '0701234573', 'Finance', 'Financial Analyst', 1900000.00, '2023-04-15', 'active'),
('EMP008', 'Mercy', 'Niyonshuti', 'mercy.niyonshuti@company.com', '0701234574', 'Human Resources', 'HR Assistant', 1600000.00, '2023-06-01', 'active'),
('EMP009', 'Umar Khemis', 'Ahmed', 'umar.ahmed@company.com', '0701234575', 'Marketing', 'Digital Marketing Specialist', 1700000.00, '2023-07-10', 'active');
