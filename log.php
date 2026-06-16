<?php
require_once 'includes/auth.php';
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = '';
$old_username = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'db.php';

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $old_username = $username;

    if ($username === '' || $password === '') {
        $error = 'Username dan password harus diisi.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1 LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']       = $user['id'];
                $_SESSION['username']      = $user['username'];
                $_SESSION['user_role']     = $user['role'];
                $_SESSION['user_fullname'] = $user['full_name'];
                header("Location: index.php");
                exit;
            } else {
                $error = 'Username atau password salah.';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi.';
        }
    }
}

$role_icons = [
    'Administrator' => '&#128272;',
    'Technician'    => '&#128295;',
    'Viewer'        => '&#128065;',
    'User'          => '&#128100;',
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Maintenance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login">
        <h1>Login</h1>

        <?php if ($error): ?>
            <div class="login-alert">
                <span class="alert-icon">&#9888;</span>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>
        <form method="POST" class="login-form" id="loginForm">
            <input type="text" name="username" id="username" placeholder="Username" value="<?= htmlspecialchars($old_username) ?>" required autofocus required="required" />
            <input type="password" name="password" id="password" placeholder="Password" required="required" />

            <button type="submit" class="btn btn-primary btn-block btn-large">Let me in.</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    eyeIcon.innerHTML = type === 'password' ? '&#128065;' : '&#128064;';
                });
            }

            // Role cards auto-fill
            document.querySelectorAll('.role-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    const username = this.dataset.username;
                    const password = this.dataset.password;

                    document.querySelectorAll('.role-card').forEach(function(c) {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');

                    document.getElementById('username').value = username;
                    document.getElementById('password').value = password;

                    document.getElementById('username').dispatchEvent(new Event('input'));
                });
            });

            // Submit loading state
            document.getElementById('loginForm').addEventListener('submit', function() {
                const btn = document.getElementById('loginBtn');
                btn.disabled = true;
                btn.querySelector('.btn-text').style.display = 'none';
                btn.querySelector('.btn-loader').style.display = 'flex';
            });

            // Trigger floating label on page load
            const usernameInput = document.getElementById('username');
            if (usernameInput.value) {
                usernameInput.dispatchEvent(new Event('input'));
            }
        });
    </script>
</body>

</html>