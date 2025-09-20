<?php
/**
 * Employee Management System - User Interface
 * Created by: Ayen Geoffrey Alexander
 * Registration Number: 2024/A/KCS/5102/G/F
 */

// Start session for messages
session_start();

// Include the handler to get data
require_once 'handler.php';

// Get session messages if they exist
$message = '';
$message_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e2c1e6ff 0%, #66573bff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(213, 216, 8, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #547dd6ff 0%, #abe704ff 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            background: #f8f9fa;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #e05708ff;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #6c0fd6ff;
            font-size: 1.1em;
        }

        .content {
            padding: 30px;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
            margin: 5px;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #27ae60;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f39c12;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background: #34495e;
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .status.active {
            background: #d4edda;
            color: #155724;
        }

        .status.inactive {
            background: #fff3cd;
            color: #856404;
        }

        .status.terminated {
            background: #f8d7da;
            color: #721c24;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ecf0f1;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Employee Management System</h1>
            <p>Developed by: Ayen Geoffrey Alexander | Registration: 2024/A/KCS/5102/G/F</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo isset($status_counts['active']) ? $status_counts['active'] : 0; ?></div>
                <div class="stat-label">Active Employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo isset($status_counts['inactive']) ? $status_counts['inactive'] : 0; ?></div>
                <div class="stat-label">Inactive Employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo isset($status_counts['terminated']) ? $status_counts['terminated'] : 0; ?></div>
                <div class="stat-label">Terminated Employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo array_sum($status_counts); ?></div>
                <div class="stat-label">Total Employees</div>
            </div>
        </div>

        <div class="content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Employee Records</h2>
                <button class="btn btn-success" onclick="openModal('createModal')">Add New Employee</button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($employees && $employees->num_rows > 0): ?>
                            <?php while ($row = $employees->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['employee_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                                    <td><?php echo number_format($row['salary'], 0); ?> UGX</td>
                                    <td><span class="status <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    <td>
                                        <button class="btn btn-warning" onclick="editEmployee(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                                        <button class="btn btn-danger" onclick="deleteEmployee(<?php echo $row['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px; color: #7f8c8d;">
                                    No employees found. Click "Add New Employee" to get started.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Employee Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('createModal')">&times;</span>
            <h2>Add New Employee</h2>
            <form method="POST" action="handler.php">
                <input type="hidden" name="action" value="create">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="employee_id">Employee ID:</label>
                        <input type="text" id="employee_id" name="employee_id" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="terminated">Terminated</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" maxlength="50" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" maxlength="15">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="department">Department:</label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Operations">Operations</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input type="text" id="position" name="position" maxlength="50" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="salary">Salary (UGX):</label>
                        <input type="number" id="salary" name="salary" step="0.01" min="1000000" required>
                    </div>
                    <div class="form-group">
                        <label for="hire_date">Hire Date:</label>
                        <input type="date" id="hire_date" name="hire_date" required>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" onclick="closeModal('createModal')">Cancel</button>
                    <button type="submit" class="btn btn-success">Create Employee</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Employee</h2>
            <form method="POST" action="handler.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="edit_id" name="id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_employee_id">Employee ID:</label>
                        <input type="text" id="edit_employee_id" name="employee_id" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status:</label>
                        <select id="edit_status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="terminated">Terminated</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_first_name">First Name:</label>
                        <input type="text" id="edit_first_name" name="first_name" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_last_name">Last Name:</label>
                        <input type="text" id="edit_last_name" name="last_name" maxlength="50" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_email">Email:</label>
                        <input type="email" id="edit_email" name="email" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone:</label>
                        <input type="text" id="edit_phone" name="phone" maxlength="15">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_department">Department:</label>
                        <select id="edit_department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Operations">Operations</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_position">Position:</label>
                        <input type="text" id="edit_position" name="position" maxlength="50" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_salary">Salary (UGX):</label>
                        <input type="number" id="edit_salary" name="salary" step="0.01" min="1000000" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_hire_date">Hire Date:</label>
                        <input type="date" id="edit_hire_date" name="hire_date" required>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Employee</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this employee? This action cannot be undone.</p>
            <form method="POST" action="handler.php" id="deleteForm">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" id="delete_id" name="id">
                
                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" onclick="closeModal('deleteModal')">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Employee</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function editEmployee(employee) {
            document.getElementById('edit_id').value = employee.id;
            document.getElementById('edit_employee_id').value = employee.employee_id;
            document.getElementById('edit_first_name').value = employee.first_name;
            document.getElementById('edit_last_name').value = employee.last_name;
            document.getElementById('edit_email').value = employee.email;
            document.getElementById('edit_phone').value = employee.phone;
            document.getElementById('edit_department').value = employee.department;
            document.getElementById('edit_position').value = employee.position;
            document.getElementById('edit_salary').value = employee.salary;
            document.getElementById('edit_hire_date').value = employee.hire_date;
            document.getElementById('edit_status').value = employee.status;
            
            openModal('editModal');
        }

        function deleteEmployee(id) {
            document.getElementById('delete_id').value = id;
            openModal('deleteModal');
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
