<?php require '_protected.php'; ?>
<?php
// Δημιουργία
if ($_POST['action'] ?? '' === 'create') {
    $title = trim($_POST['title']);
    $code = trim($_POST['code']);
    $stmt = $pdo->prepare("INSERT INTO courses (title, code, teacher_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $code, $teacher_id]);
}

// Διαγραφή
if ($_GET['delete'] ?? 0) {
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$_GET['delete'], $teacher_id]);
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Διαχείριση Μαθημάτων</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2>Μαθήματά μου</h2>
        <form method="POST" class="mb-4">
            <input type="hidden" name="action" value="create">
            <div class="row g-2">
                <div class="col-md-5"><input type="text" name="title" class="form-control" placeholder="Τίτλος" required></div>
                <div class="col-md-3"><input type="text" name="code" class="form-control" placeholder="Κωδικός" required></div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Δημιουργία</button></div>
            </div>
        </form>

        <div class="row">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE teacher_id = ?");
            $stmt->execute([$teacher_id]);
            while ($c = $stmt->fetch()):
            ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h5><?= htmlspecialchars($c['title']) ?></h5>
                                <p class="text-muted"><?= $c['code'] ?></p>
                            </div>
                            <a href="?delete=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Σίγουρα;')">Διαγραφή</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>