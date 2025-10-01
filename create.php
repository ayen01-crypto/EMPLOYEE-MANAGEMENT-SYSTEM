<?php
require_once 'handler.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        header('Location: index.php');
        exit();
    } else {
        header('Location: error.php?msg=creation_failed');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add New Employee</h2>
    <form method="POST" action="create.php">
        <input type="text" name="employee_id" placeholder="Employee ID" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone">
        <select name="department" required>
            <option value="">Department</option>
            <option value="Human Resources">Human Resources</option>
            <option value="Information Technology">Information Technology</option>
            <option value="Finance">Finance</option>
            <option value="Marketing">Marketing</option>
            <option value="Operations">Operations</option>
        </select>
        <input type="text" name="position" placeholder="Position" required>
        <input type="number" name="salary" placeholder="Salary (UGX)" min="1000000" required>
        <input type="date" name="hire_date" required>
        <select name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="terminated">Terminated</option>
        </select>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="index.php" class="btn">Cancel</a>
    </form>
</div>
</body>
</html>
