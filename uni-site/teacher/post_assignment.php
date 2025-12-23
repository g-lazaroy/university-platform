<?php require '_protected.php'; ?>
<?php
if ($_POST['action'] ?? '' === 'post') {
    $course_id = $_POST['course_id'];
    $title = trim($_POST['title']);
    $desc = $_POST['description'];
    $due = $_POST['due_date'];
    $stmt = $pdo->prepare("INSERT INTO assignments (course_id, title, description, due_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$course_id, $title, $desc, $due]);
    $success = "Εργασία αναρτήθηκε!";
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Ανάρτηση Εργασίας</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2>Νέα Εργασία</h2>
        <?php if (isset($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
        <form method="POST">
            <input type="hidden" name="action" value="post">
            <div class="mb-3">
                <label>Μάθημα</label>
                <select name="course_id" class="form-select" required>
                    <?php
                    $stmt = $pdo->prepare("SELECT id, title FROM courses WHERE teacher_id = ?");
                    $stmt->execute([$teacher_id]);
                    while ($c = $stmt->fetch()): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3"><input type="text" name="title" class="form-control" placeholder="Τίτλος" required></div>
            <div class="mb-3"><textarea name="description" class="form-control" rows="3" placeholder="Περιγραφή"></textarea></div>
            <div class="mb-3"><input type="date" name="due_date" class="form-control" required></div>
            <button type="submit" class="btn btn-primary">Ανάρτηση</button>
        </form>
    </div>
</body>
</html>