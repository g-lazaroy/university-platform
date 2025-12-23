<?php
require 'config.php';
session_destroy();
header("Location: auth.php");
exit;
?>