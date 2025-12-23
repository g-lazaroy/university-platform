<?php
require 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: /uni-site/dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $reg_code = trim($_POST['reg_code']);

        if ($role === 'student' && $reg_code !== STUDENT_CODE) {
            $error = "Λάθος κωδικός φοιτητή!";
        } elseif ($role === 'teacher' && $reg_code !== TEACHER_CODE) {
            $error = "Λάθος κωδικός καθηγητή!";
        } else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $username]);
            if ($stmt->fetch()) {
                $error = "Email ή username υπάρχει ήδη!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $password, $role]);
                $success = "Εγγραφή επιτυχής! Συνδέσου.";
            }
        }
    }

    if ($action === 'login') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role'];
            header("Location: /uni-site/dashboard.php");
            exit;
        } else {
            $error = "Λάθος email ή κωδικός!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Σύνδεση / Εγγραφή</title>
    <link rel="stylesheet" href="style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('photos/photo4.jpg') center/cover no-repeat; min-height: 100dvh; margin: 0;">

    <!-- ΣΤΑΤΙΚΟ NAVBAR (χωρίς dashboard_navbar) -->
    <nav class="navbar">
        <div class="logo">Πανεπιστήμιο Ηλιούπολης</div>
        <ul class="nav-links">
            <li><a href="/uni-site/index.html">Αρχική</a></li>
            <li><a href="/uni-site/about.html">Πληροφορίες</a></li>
            <li><a href="/uni-site/map.html">Χάρτης</a></li>
            <li><a href="/uni-site/auth.php" class="active">Log in</a></li>
        </ul>
    </nav>

    <div class="auth-container">
        <h1 id="form-title">Σύνδεση</h1>

        <!-- LOGIN FORM -->
        <div id="login-form" class="form-section active">
            <form method="POST">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required placeholder="name@uni.gr">
                </div>
                <div class="form-group">
                    <label for="login-password">Κωδικός</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <button type="submit" class="btn btn-login">Σύνδεση</button>
            </form>
            <p class="toggle-link">
                Νέος χρήστης; <a onclick="showRegister()">Κάνε Εγγραφή</a>
            </p>
        </div>

        <!-- REGISTER FORM -->
        <div id="register-form" class="form-section">
            <form method="POST">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="reg-username">Username</label>
                    <input type="text" id="reg-username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="reg-email">Email</label>
                    <input type="email" id="reg-email" name="email" required placeholder="name@uni.gr">
                </div>
                <div class="form-group">
                    <label for="reg-password">Κωδικός</label>
                    <input type="password" id="reg-password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="reg-role">Ρόλος</label>
                    <select id="reg-role" name="role" required>
                        <option value="student">Φοιτητής</option>
                        <option value="teacher">Καθηγητής</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="reg-code">Κωδικός Εγγραφής</label>
                    <input type="text" id="reg-code" name="reg_code" required placeholder="STUD2025 ή PROF2025">
                </div>
                <button type="submit" class="btn btn-register">Εγγραφή</button>
            </form>
            <p class="toggle-link">
                Έχεις λογαριασμό; <a onclick="showLogin()">Σύνδεση</a>
            </p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (isset($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
    </div>

    <script>
        function showRegister() {
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.add('active');
            document.getElementById('form-title').textContent = 'Εγγραφή';
        }
        function showLogin() {
            document.getElementById('register-form').classList.remove('active');
            document.getElementById('login-form').classList.add('active');
            document.getElementById('form-title').textContent = 'Σύνδεση';
        }
    </script>
</body>
</html>