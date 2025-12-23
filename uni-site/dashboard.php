<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}

$user_role = $_SESSION['role_id'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <!-- NAVBAR -->
    <?php include 'dashboard_navbar.php'; ?>

    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center p-5">
                        <h1 class="display-5 fw-bold text-maroon">Καλώς ήρθες, <?= htmlspecialchars($username) ?>!</h1>
                        <p class="lead text-muted">Ρόλος: <strong class="text-maroon"><?= $user_role === 'student' ? 'Φοιτητής' : 'Καθηγητής' ?></strong></p>
                        <hr class="my-4">
                        <p class="fs-5">Επίλεξε από το μενού τις διαθέσιμες λειτουργίες.</p>
                    </div>
                </div>

                <!-- QUICK LINKS -->
                <div class="row mt-4 g-3">
                    <?php if ($user_role === 'student'): ?>
                        <div class="col-md-4">
                            <a href="student/courses.php" class="text-decoration-none">
                                <div class="card h-100 text-center p-4 border-0 shadow-sm hover-card">
                                    <div class="fs-1 text-primary">📚</div>
                                    <h5 class="mt-3">Μαθήματα</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="student/assignments.php" class="text-decoration-none">
                                <div class="card h-100 text-center p-4 border-0 shadow-sm hover-card">
                                    <div class="fs-1 text-success">📝</div>
                                    <h5 class="mt-3">Εργασίες</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="student/grades.php" class="text-decoration-none">
                                <div class="card h-100 text-center p-4 border-0 shadow-sm hover-card">
                                    <div class="fs-1 text-warning">⭐</div>
                                    <h5 class="mt-3">Βαθμοί</h5>
                                </div>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="col-md-4">
                            <a href="teacher/manage_courses.php" class="text-decoration-none">
                                <div class="card h-100 text-center p-4 border-0 shadow-sm hover-card">
                                    <div class="fs-1 text-info">📖</div>
                                    <h5 class="mt-3">Διαχείριση Μαθημάτων</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="teacher/post_assignment.php" class="text-decoration-none">
                                <div class="card h-100 text-center p-4 border-0 shadow-sm hover-card">
                                    <div class="fs-1 text-danger">➕</div>
                                    <h5 class="mt-3">Νέα Εργασία</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="teacher/submissions.php" class="text-decoration-none">
                                <div class="card h-100 text-center p-4 border-0 shadow-sm hover-card">
                                    <div class="fs-1 text-secondary">📥</div>
                                    <h5 class="mt-3">Υποβολές</h5>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>