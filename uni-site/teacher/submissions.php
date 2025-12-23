<?php require '_protected.php'; ?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Υποβολές</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2>Υποβολές Φοιτητών</h2>
        <?php
        $stmt = $pdo->prepare("
            SELECT s.id, a.title, u.username, s.file_path, s.grade, s.feedback, c.title as course
            FROM submissions s
            JOIN assignments a ON s.assignment_id = a.id
            JOIN users u ON s.student_id = u.id
            JOIN courses c ON a.course_id = c.id
            WHERE c.teacher_id = ?
        ");
        $stmt->execute([$teacher_id]);
        while ($sub = $stmt->fetch()):
        ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5><?= htmlspecialchars($sub['title']) ?> (<?= $sub['course'] ?>)</h5>
                    <p><strong>Φοιτητής:</strong> <?= htmlspecialchars($sub['username']) ?></p>
                    <p><a href="<?= $sub['file_path'] ?>" target="_blank">Λήψη αρχείου</a></p>
                    <?php if ($sub['grade'] === null): ?>
                        <form method="POST" action="grade.php">
                            <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                            <div class="row g-2">
                                <div class="col"><input type="number" step="0.1" min="0" max="10" name="grade" class="form-control" placeholder="Βαθμός" required></div>
                                <div class="col"><input type="text" name="feedback" class="form-control" placeholder="Σχόλιο"></div>
                                <div class="col-auto"><button type="submit" class="btn btn-success btn-sm">Βαθμολόγηση</button></div>
                            </div>
                        </form>
                    <?php else: ?>
                        <p class="text-success">Βαθμός: <strong><?= $sub['grade'] ?></strong> | <?= htmlspecialchars($sub['feedback']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>