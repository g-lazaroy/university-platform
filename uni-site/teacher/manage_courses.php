<?php require '_protected.php'; ?>
<?php
// Δημιουργία μαθήματος
if ($_POST['action'] ?? '' === 'create') {
    $title = trim($_POST['title']);
    $code = trim($_POST['code']);
    $stmt = $pdo->prepare("INSERT INTO courses (title, code, teacher_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $code, $teacher_id]);
    $success = "Μάθημα δημιουργήθηκε!";
}

// Εγγραφή φοιτητή σε μάθημα
if ($_POST['action'] ?? '' === 'enroll') {
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO enrollments (student_id, course_id) VALUES (?, ?)");
    $stmt->execute([$student_id, $course_id]);
    $success = "Φοιτητής εγγράφηκε στο μάθημα!";
}

// Διαγραφή μαθήματος
if ($_GET['delete'] ?? 0) {
    $del_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$del_id, $teacher_id]);
    $success = "Μάθημα διαγράφηκε!";
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
<body>
    <?php include '../dashboard_navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Τα Μαθήματά μου</h2>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- ΦΟΡΜΑ ΔΗΜΙΟΥΡΓΙΑΣ ΜΑΘΗΜΑΤΟΣ -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Δημιουργία Νέου Μαθήματος</h5>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="title" class="form-control" placeholder="Τίτλος μαθήματος" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="code" class="form-control" placeholder="Κωδικός (π.χ. CS101)" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Δημιουργία</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ΛΙΣΤΑ ΜΑΘΗΜΑΤΩΝ -->
        <div class="row">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE teacher_id = ? ORDER BY created_at DESC");
            $stmt->execute([$teacher_id]);
            if ($stmt->rowCount() == 0): ?>
                <div class="col-12">
                    <div class="alert alert-info">Δεν έχετε δημιουργήσει μαθήματα ακόμα.</div>
                </div>
            <?php else:
                while ($c = $stmt->fetch()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($c['title']) ?></h5>
                                <p class="text-muted mb-2">Κωδικός: <strong><?= htmlspecialchars($c['code']) ?></strong></p>

                                <!-- ΕΓΓΡΑΦΗ ΦΟΙΤΗΤΗ -->
                                <div class="mt-auto">
                                    <h6>Εγγραφή Φοιτητή</h6>
                                    <form method="POST" class="mb-3">
                                        <input type="hidden" name="action" value="enroll">
                                        <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
                                        <div class="row g-2">
                                            <div class="col">
                                                <select name="student_id" class="form-select" required>
                                                    <?php
                                                    $stu_stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'student'");
                                                    $stu_stmt->execute();
                                                    while ($stu = $stu_stmt->fetch()): ?>
                                                        <option value="<?= $stu['id'] ?>"><?= htmlspecialchars($stu['username']) ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-success btn-sm">Εγγραφή</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- ΔΙΑΓΡΑΦΗ -->
                                    <a href="?delete=<?= $c['id'] ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Σίγουρα θέλετε να διαγράψετε το μάθημα;');">
                                        Διαγραφή Μαθήματος
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>