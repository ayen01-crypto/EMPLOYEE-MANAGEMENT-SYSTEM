<?php
require_once 'handler.php';

// Handle GET request to fetch employee data for editing
if (isset($_GET['id'])) {
    $employeeData = $employee->readOne($_GET['id']);
    if (!$employeeData) {
        header('Location: error.php?msg=Employee+not+found');
        exit();
    }
} else {
    header('Location: error.php?msg=No+employee+ID+provided');
    exit();
}

// Handle POST request to update employee
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employee->id = $_POST['id'];
        $employee->employee_id = $_POST['employee_id'];
        $employee->first_name = $_POST['first_name'];
        $employee->last_name = $_POST['last_name'];
        $employee->email = $_POST['email'];
        $employee->phone = $_POST['phone'];
        <?php
        require_once 'handler.php';
        if (!isset($_GET['id'])) { header('Location: error.php?msg=No+ID'); exit(); }
        $employeeData = $employee->readOne($_GET['id']);
        if (!$employeeData) { header('Location: error.php?msg=Not+found'); exit(); }
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
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Edit Employee</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
        <div class="container">
            <h2>Edit Employee</h2>
            <form method="POST" action="edit.php?id=<?php echo $employeeData['id']; ?>">
                <input type="hidden" name="id" value="<?php echo $employeeData['id']; ?>">
                <input type="text" name="employee_id" value="<?php echo $employeeData['employee_id']; ?>" required>
                <input type="text" name="first_name" value="<?php echo $employeeData['first_name']; ?>" required>
                <input type="text" name="last_name" value="<?php echo $employeeData['last_name']; ?>" required>
                <input type="email" name="email" value="<?php echo $employeeData['email']; ?>" required>
                <input type="text" name="phone" value="<?php echo $employeeData['phone']; ?>">
                <select name="department" required>
                    <option value="Human Resources" <?php if($employeeData['department']==='Human Resources')echo'selected';?>>Human Resources</option>
                    <option value="Information Technology" <?php if($employeeData['department']==='Information Technology')echo'selected';?>>Information Technology</option>
                    <option value="Finance" <?php if($employeeData['department']==='Finance')echo'selected';?>>Finance</option>
                    <option value="Marketing" <?php if($employeeData['department']==='Marketing')echo'selected';?>>Marketing</option>
                    <option value="Operations" <?php if($employeeData['department']==='Operations')echo'selected';?>>Operations</option>
                </select>
                <input type="text" name="position" value="<?php echo $employeeData['position']; ?>" required>
                <input type="number" name="salary" value="<?php echo $employeeData['salary']; ?>" min="1000000" required>
                <input type="date" name="hire_date" value="<?php echo $employeeData['hire_date']; ?>" required>
                <select name="status" required>
                    <option value="active" <?php if($employeeData['status']==='active')echo'selected';?>>Active</option>
                    <option value="inactive" <?php if($employeeData['status']==='inactive')echo'selected';?>>Inactive</option>
                    <option value="terminated" <?php if($employeeData['status']==='terminated')echo'selected';?>>Terminated</option>
                </select>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="index.php" class="btn">Cancel</a>
            </form>
        </div>
        </body>
        </html>
                        <label for="phone">Phone:</label>
