
# Employee Management System

**Developed by:** Ayen Geoffrey Alexander  
**Registration Number:** 2024/A/KCS/5102/G/F

## Overview

This is a modular Employee Management System built with PHP and MySQL. Each file is concise (under 100 lines) and focused on a single responsibility for easy maintenance.

## Features

- Add, edit, delete, and view employees
- Simple, responsive UI
- MySQL database connection
- Secure CRUD operations

## System Requirements

- **Web Server:** Apache/Nginx
- **PHP:** Version 7.4 or higher
- **MySQL:** Version 5.7 or higher
- **XAMPP/WAMP/LAMP** (recommended for local development)

## Installation Instructions

### 1. Database Setup
1. Start your XAMPP/WAMP server
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Import the `database_schema.sql` file to create the database and sample data
4. The database will be created with the name `employee_management`

### 2. File Setup
1. Copy all files to your web server directory (e.g. `htdocs` for XAMPP)

### 3. Configuration
1. Update database credentials in `handler.php` if needed:
   ```php
   private $host = 'localhost';
   private $db_name = 'employee_management';
   private $username = 'root';
   private $password = '';
   ```

### 4. Access the Application
1. Open your web browser
2. Navigate to: `http://localhost/index.php`
3. The Employee Management System dashboard will load

## File Structure

```
employee-management-system/
├── index.php         # Main dashboard and employee list
├── create.php        # Add new employee
├── edit.php          # Edit employee
├── delete.php        # Delete employee
├── error.php         # Error messages
├── handler.php       # PHP backend logic and database operations
├── style.css         # Styles
├── database_schema.sql # Database creation script
└── README.md         # This documentation file
```

## Database Schema

### Employees Table
- `id` - Primary key (auto-increment)
- `employee_id` - Unique employee identifier
- `first_name` - Employee's first name
- `last_name` - Employee's last name
- `email` - Email address (unique)
- `phone` - Phone number
- `department` - Department name
- `position` - Job position
- `salary` - Annual salary (in UGX, minimum 1,000,000 UGX)
- `hire_date` - Date of employment
- `status` - Employee status (active/inactive/terminated)
- `created_at` - Record creation timestamp
- `updated_at` - Last update timestamp

### Departments Table
- `id` - Primary key (auto-increment)
- `department_name` - Department name (unique)
- `description` - Department description
- `manager_id` - Department manager ID
- `created_at` - Record creation timestamp

## Usage Guide

### Adding a New Employee
1. Click the "Add New Employee" button
2. Fill in all required fields:
   - Employee ID (unique)
   - First and Last Name
   - Email address
   - Phone number
   - Department (select from dropdown)
   - Position
   - Salary
   - Hire Date
   - Status
3. Click "Create Employee"

### Editing an Employee
1. Click the "Edit" button next to any employee record
2. Modify the desired fields
3. Click "Update Employee"

### Deleting an Employee
1. Click the "Delete" button next to any employee record
2. Confirm the deletion in the popup dialog

### Viewing Employee Statistics
- The dashboard displays real-time statistics:
  - Active Employees
  - Inactive Employees
  - Terminated Employees
  - Total Employees

## Technical Implementation

### Object-Oriented Design
The system follows PHP OOP principles with:
- **Database Class** - Handles database connections (in handler.php)
- **Employee Class** - Manages all employee operations (in handler.php)
- **Separation of Concerns** - Clear separation between interface (interface.php) and logic (handler.php)

### Security Features
- **Prepared Statements** - All database queries use prepared statements to prevent SQL injection
- **Input Validation** - Server-side validation for all user inputs
- **Error Handling** - Comprehensive error handling with user-friendly messages
- **Data Sanitization** - All output is properly escaped using `htmlspecialchars()`

### Code Quality
- **Self-Documenting Code** - Clear variable and function names
- **Comments** - Comprehensive inline documentation
- **Error Messages** - Descriptive error messages for debugging
- **Consistent Formatting** - Clean, readable code structure

## Sample Data

The system comes pre-loaded with sample employee data:
- 5 sample employees across different departments
- 5 predefined departments
- Various employee statuses for testing

## Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers (responsive design)

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Ensure MySQL is running in XAMPP/WAMP
   - Check database credentials in `config/database.php`
   - Verify database exists and is imported correctly

2. **Page Not Loading**
   - Ensure web server is running
   - Check file permissions
   - Verify correct URL path

3. **Forms Not Working**
   - Check PHP error logs
   - Ensure all required fields are filled
   - Verify database connection

### Error Messages
The system provides clear error messages for:
- Database connection issues
- Invalid form data
- Missing required fields
- Duplicate employee IDs or emails

## Assignment Requirements Compliance

This system meets all assignment requirements:

 **PHP with OOP-MySQLi** - Implemented using object-oriented PHP with MySQLi  
 **Prepared Statements** - All database operations use prepared statements  
 **Error Handling** - Comprehensive error handling throughout the application  
 **Database Connection Management** - Proper connection handling and cleanup  
 **HTML Forms** - Interactive forms for all CRUD operations  
**CRUD Operations** - Complete Create, Read, Update, Delete functionality  
## Future Enhancements

Potential improvements for the system:
- User authentication and authorization
- Advanced search and filtering
- Employee photo uploads
- Department management interface
- Reporting and analytics
- Export functionality (PDF/Excel)
- Email notifications
- Audit trail for changes

---

**Note:** This system is designed for educational purposes and demonstrates best practices in PHP OOP development, database design, and web application security.

