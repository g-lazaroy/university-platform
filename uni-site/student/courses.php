<?php require '_protected.php'; ?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Μαθήματα</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2>Τα Μαθήματά μου</h2>
        <div class="row">
            <?php
            $stmt = $pdo->prepare("
                SELECT c.id, c.title, c.code, u.username as teacher
                FROM courses c
                JOIN enrollments e ON c.id = e.course_id
                JOIN users u ON c.teacher_id = u.id
                WHERE e.student_id = ?
            ");
            $stmt->execute([$student_id]);
            while ($course = $stmt->fetch()):
            ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                            <p class="card-text">
                                <strong>Κωδικός:</strong> <?= $course['code'] ?><br>
                                <strong>Καθηγητής:</strong> <?= htmlspecialchars($course['teacher']) ?>
                            </p>
                            <a href="assignments.php?course=<?= $course['id'] ?>" class="btn btn-sm btn-outline-primary">Εργασίες</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>