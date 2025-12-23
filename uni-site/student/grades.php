<?php require '_protected.php'; ?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Βαθμοί</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2>Βαθμολογίες</h2>
        <table class="table table-striped">
            <thead><tr><th>Μάθημα</th><th>Εργασία</th><th>Βαθμός</th><th>Σχόλιο</th></tr></thead>
            <tbody>
            <?php
            $stmt = $pdo->prepare("
                SELECT c.title, a.title as assignment, s.grade, s.feedback
                FROM submissions s
                JOIN assignments a ON s.assignment_id = a.id
                JOIN courses c ON a.course_id = c.id
                WHERE s.student_id = ? AND s.grade IS NOT NULL
            ");
            $stmt->execute([$student_id]);
            while ($g = $stmt->fetch()):
            ?>
                <tr>
                    <td><?= htmlspecialchars($g['title']) ?></td>
                    <td><?= htmlspecialchars($g['assignment']) ?></td>
                    <td><strong><?= $g['grade'] ?></strong></td>
                    <td><?= $g['feedback'] ? htmlspecialchars($g['feedback']) : '-' ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>