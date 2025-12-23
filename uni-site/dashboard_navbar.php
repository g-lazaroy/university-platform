<?php
// dashboard_navbar.php
// Εμφανίζεται ΜΟΝΟ αν είσαι logged in
if (!isset($_SESSION['user_id'])) {
    // Αν δεν είσαι logged in → ΜΗΝ εμφανίζεις navbar (ή μόνο βασικά links)
    return; // ή echo '' ; 
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-maroon">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/uni-site/dashboard.php">Πανεπιστήμιο Ηλιούπολης</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/uni-site/index.html">Αρχική</a></li>

                <?php if ($_SESSION['role_id'] === 'student'): ?>
                    <li class="nav-item"><a class="nav-link" href="/uni-site/student/courses.php">Μαθήματα</a></li>
                    <li class="nav-item"><a class="nav-link" href="/uni-site/student/assignments.php">Εργασίες</a></li>
                    <li class="nav-item"><a class="nav-link" href="/uni-site/student/grades.php">Βαθμοί</a></li>
                <?php endif; ?>

                <?php if ($_SESSION['role_id'] === 'teacher'): ?>
                    <li class="nav-item"><a class="nav-link" href="/uni-site/teacher/manage_courses.php">Μαθήματα</a></li>
                    <li class="nav-item"><a class="nav-link" href="/uni-site/teacher/post_assignment.php">Νέα Εργασία</a></li>
                    <li class="nav-item"><a class="nav-link" href="/uni-site/teacher/submissions.php">Υποβολές</a></li>
                <?php endif; ?>

                <li class="nav-item"><a class="nav-link" href="/uni-site/logout.php">Αποσύνδεση</a></li>
            </ul>
        </div>
    </div>
</nav>