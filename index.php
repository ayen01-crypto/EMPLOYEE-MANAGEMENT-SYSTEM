<?php
// index.php - Main entry point for Employee Management System
<?php
/**
 * Employee Management System - User Interface (moved from interface.php)
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
<?php
session_start();
require_once 'handler.php';
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : '';
if ($message) { unset($_SESSION['message'], $_SESSION['message_type']); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Employee Management System</h1>
        <p>Developed by: Ayen Geoffrey Alexander | Registration: 2024/A/KCS/5102/G/F</p>
    </div>
    <?php if ($message): ?>
        <div class="message <?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <div style="margin:20px 0; text-align:right;">
        <a href="create.php" class="btn btn-success">Add New Employee</a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Employee ID</th><th>Name</th><th>Email</th><th>Department</th><th>Position</th><th>Salary</th><th>Status</th><th>Actions</th>
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
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this employee?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" style="text-align:center;">No employees found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
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
?>
