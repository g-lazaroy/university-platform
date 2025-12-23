<?php
require '../config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 'student') {
    die("Forbidden Action");
}
$student_id = $_SESSION['user_id'];
?>