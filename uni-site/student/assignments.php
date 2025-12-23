<?php require '_protected.php'; ?>
<?php
$course_id = $_GET['course'] ?? 0;
if ($course_id) {
    $check = $pdo->prepare("SELECT 1 FROM enrollments WHERE student_id = ? AND course_id = ?");
    $check->execute([$student_id, $course_id]);
    if (!$check->fetch()) die("Forbidden");
}

// Υποβολή
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $assignment_id = $_POST['assignment_id'];
    $upload_dir = "../assets/uploads/";
    $file_name = time() . "_" . basename($_FILES['file']['name']);
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        $stmt = $pdo->prepare("INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)
                               ON DUPLICATE KEY UPDATE file_path = VALUES(file_path), submitted_at = CURRENT_TIMESTAMP");
        $stmt->execute([$assignment_id, $student_id, $file_path]);
        $success = "Υποβλήθηκε!";
    } else {
        $error = "Αποτυχία upload.";
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Εργασίες</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2>Εργασίες <?php if ($course_id): ?>
            <a href="courses.php" class="btn btn-sm btn-secondary float-end">Πίσω</a>
        <?php endif; ?></h2>

        <?php if (isset($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
        <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

        <?php
        $sql = "SELECT a.*, c.title as course, s.file_path, s.grade, s.feedback
                FROM assignments a
                JOIN courses c ON a.course_id = c.id
                LEFT JOIN submissions s ON a.id = s.assignment_id AND s.student_id = ?
                WHERE 1=1";
        $params = [$student_id];
        if ($course_id) { $sql .= " AND a.course_id = ?"; $params[] = $course_id; }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        while ($a = $stmt->fetch()):
        ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5><?= htmlspecialchars($a['title']) ?> (<?= $a['course'] ?>)</h5>
                    <p><strong>Προθεσμία:</strong> <?= $a['due_date'] ?></p>
                    <?php if ($a['file_path']): ?>
                        <p class="text-success">Υποβλήθηκε: <?= basename($a['file_path']) ?>
                            <?php if ($a['grade'] !== null): ?> | Βαθμός: <strong><?= $a['grade'] ?></strong> <?php endif; ?>
                            <?php if ($a['feedback']): ?> | Σχόλιο: <?= htmlspecialchars($a['feedback']) ?> <?php endif; ?>
                        </p>
                    <?php else: ?>
                        <form method="POST" enctype="multipart/form-data" class="mt-2">
                            <input type="hidden" name="assignment_id" value="<?= $a['id'] ?>">
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" required>
                                <button type="submit" class="btn btn-primary">Υποβολή</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>