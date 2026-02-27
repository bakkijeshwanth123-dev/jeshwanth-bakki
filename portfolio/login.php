<?php
session_start();

$username = "admin";
$password = "admin123";

if (isset($_POST['login'])) {
    if ($_POST['user'] == $username && $_POST['pass'] == $password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
        }
    </style>
</head>
<body class="dark-theme">
    <div class="glass-card login-box">
        <h2 style="margin-bottom: 2rem; text-align: center;">Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color: var(--accent);'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="user" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="pass" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary" style="width: 100%;">Login</button>
        </form>
    </div>
</body>
</html>
