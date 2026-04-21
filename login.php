<?php
session_start();
require_once 'db.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role']; // Сохраняем роль

    if ($user['role'] == 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
}
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход — Турагенство</title>
    <link rel="stylesheet" href="style/auth_style.css">
</head>
<body>
    <div class="auth-container">
        <form action="login.php" method="POST" class="auth-form">
            <h2>Вход в личный кабинет</h2>
            <?php if($error) echo "<p class='error'>$error</p>"; ?>
            
            <input type="text" name="username" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" required>
            
            <button type="submit">Войти</button>
            <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            <p><a href="index.html">На главную</a></p>
        </form>
    </div>
</body>
</html>