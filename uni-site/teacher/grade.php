<?php
require '_protected.php';
if ($_POST['submission_id'] ?? 0) {
    $id = $_POST['submission_id'];
    $grade = $_POST['grade'];
    $feedback = $_POST['feedback'];
    $stmt = $pdo->prepare("UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?");
    $stmt->execute([$grade, $feedback, $id]);
    header("Location: submissions.php");
    exit;
}
?>