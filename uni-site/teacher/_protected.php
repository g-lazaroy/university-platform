<?php
require '../config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 'teacher') {
    die("Forbidden Action");
}
$teacher_id = $_SESSION['user_id'];
?>