<?php
require_once 'handler.php';
if (!isset($_GET['id'])) { header('Location: error.php?msg=No+ID'); exit(); }
if ($employee->delete($_GET['id'])) {
    header('Location: index.php');
    exit();
} else {
    header('Location: error.php?msg=delete_failed');
    exit();
}
