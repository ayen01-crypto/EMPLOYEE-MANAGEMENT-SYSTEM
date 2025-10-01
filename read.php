<?php
require_once 'handler.php';
$employees = $employee->readAll();
foreach ($employees as $row) {
    echo $row['first_name'] . ' ' . $row['last_name'] . '<br>';
}
