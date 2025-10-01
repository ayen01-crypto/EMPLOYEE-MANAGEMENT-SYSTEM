<?php
$msg = isset($_GET['msg']) ? $_GET['msg'] : 'Unknown error.';
echo '<h2>Error</h2><p>' . htmlspecialchars($msg) . '</p><a href="index.php">Back</a>';

