<?php
require_once 'handler.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        header('Location: index.php');
        exit();
    } else {
        header('Location: error.php?msg=update_failed');
        exit();
    }
}
