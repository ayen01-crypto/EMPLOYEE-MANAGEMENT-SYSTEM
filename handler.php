<?php
/**
 * Employee Management System - Backend Handler
 * Created by: Ayen Geoffrey Alexander
 * Registration Number: 2024/A/KCS/5102/G/F
 */

// Database configuration
class Database {
    private $host = '127.0.0.1';
    private $db_name = 'employee_management';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Throw mysqli errors as exceptions for consistent handling
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            // Initialize and set a connection timeout (in seconds)
            $this->conn = mysqli_init();
            if (!$this->conn) {
                throw new Exception('Failed to initialize MySQL connection');
            }
            $this->conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

            // Use TCP by connecting to 127.0.0.1 to avoid named pipes issues on Windows
            $this->conn->real_connect($this->host, $this->username, $this->password, $this->db_name);

            // Set connection charset
            $this->conn->set_charset("utf8");

        } catch (Throwable $e) {
            // Re-throw as Exception with a clear message for upstream handling
            throw new Exception("Connection failed: " . $e->getMessage());
        }
        
        return $this->conn;
    }
    
    public function closeConnection() {
        if ($this->conn instanceof mysqli) {
            try {
                $this->conn->close();
            } catch (Throwable $e) {
                // Ignore close errors
            }
        }
    }
}

// Employee management class
class Employee {
    private $conn;
    private $table_name = "employees";

    public $id;
    public $employee_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $department;
    public $position;
    public $salary;
    public $hire_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new employee record
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (employee_id, first_name, last_name, email, phone, department, position, salary, hire_date, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssssssdss", 
            $this->employee_id, 
            $this->first_name, 
            $this->last_name, 
            $this->email, 
            $this->phone, 
            $this->department, 
            $this->position, 
            $this->salary, 
            $this->hire_date, 
            $this->status
        );

        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    // Read all employees
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        
        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }
        
        return $result;
    }

    // Read single employee by ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
        
        return null;
    }

    // Update employee record
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET employee_id = ?, first_name = ?, last_name = ?, email = ?, 
                      phone = ?, department = ?, position = ?, salary = ?, 
                      hire_date = ?, status = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssssssdssi", 
            $this->employee_id, 
            $this->first_name, 
            $this->last_name, 
            $this->email, 
            $this->phone, 
            $this->department, 
            $this->position, 
            $this->salary, 
            $this->hire_date, 
            $this->status,
            $this->id
        );

        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    // Delete employee record
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    // Search employees by name or department
    public function search($search_term) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE first_name LIKE ? OR last_name LIKE ? OR department LIKE ? 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $search_param = "%" . $search_term . "%";
        $stmt->bind_param("sss", $search_param, $search_param, $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        return $result;
    }

    // Get employee count by status
    public function getStatusCount() {
        $query = "SELECT status, COUNT(*) as count FROM " . $this->table_name . " GROUP BY status";
        $result = $this->conn->query($query);
        
        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }
        
        $status_counts = [];
        while ($row = $result->fetch_assoc()) {
            $status_counts[$row['status']] = $row['count'];
        }
        
        return $status_counts;
    }
}

// Initialize database connection
$database = new Database();
try {
    $db = $database->getConnection();
} catch (Exception $e) {
    $db = null;
}

// Initialize Employee object
$employee = new Employee($db);

// Initialize variables
$message = '';
$message_type = '';
$employees = null;
$status_counts = [];

// Handle form submissions
if ($_POST) {
    try {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'create':
                    $employee->employee_id = $_POST['employee_id'];
                    $employee->first_name = $_POST['first_name'];
                    $employee->last_name = $_POST['last_name'];
                    $employee->email = $_POST['email'];
                    $employee->phone = $_POST['phone'];
                    $employee->department = $_POST['department'];
                    $employee->position = $_POST['position'];
                    $employee->salary = $_POST['salary'];
                    $employee->hire_date = $_POST['hire_date'];
                    $employee->status = $_POST['status'];
                    
                    if ($employee->create()) {
                        $message = "Employee created successfully!";
                        $message_type = "success";
                    } else {
                        $message = "Failed to create employee.";
                        $message_type = "error";
                    }
                    break;
                    
                case 'update':
                    $employee->id = $_POST['id'];
                    $employee->employee_id = $_POST['employee_id'];
                    $employee->first_name = $_POST['first_name'];
                    $employee->last_name = $_POST['last_name'];
                    $employee->email = $_POST['email'];
                    $employee->phone = $_POST['phone'];
                    $employee->department = $_POST['department'];
                    $employee->position = $_POST['position'];
                    $employee->salary = $_POST['salary'];
                    $employee->hire_date = $_POST['hire_date'];
                    $employee->status = $_POST['status'];
                    
                    if ($employee->update()) {
                        $message = "Employee updated successfully!";
                        $message_type = "success";
                    } else {
                        $message = "Failed to update employee.";
                        $message_type = "error";
                    }
                    break;
                    
                case 'delete':
                    if ($employee->delete($_POST['id'])) {
                        $message = "Employee deleted successfully!";
                        $message_type = "success";
                    } else {
                        $message = "Failed to delete employee.";
                        $message_type = "error";
                    }
                    break;
            }
        }
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $message_type = "error";
    }
}

// Get all employees and status counts
try {
    if ($db instanceof mysqli && $db->ping()) {
        $employees = $employee->readAll();
        $status_counts = $employee->getStatusCount();
    } else {
        throw new Exception('Database connection is not available. Please ensure MySQL is running.');
    }
} catch (Exception $e) {
    $message = "Error loading employees: " . $e->getMessage();
    $message_type = "error";
    $employees = null;
    $status_counts = [];
}

// Close database connection
$database->closeConnection();

// If this is a POST request (form submission), redirect back to interface
if ($_POST) {
    // Store message in session for display after redirect
    session_start();
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $message_type;
    
    // Redirect back to interface
    header("Location: interface.php");
    exit();
}
?>
