<?php
session_start();
require_once 'db.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Получаем данные пользователя
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Получаем все бронирования пользователя (с объединением таблиц)
$orders_query = "SELECT orders.*, tours.title, tours.location, tours.image_file, tours.nights 
                 FROM orders 
                 JOIN tours ON orders.tour_id = tours.id 
                 WHERE orders.user_id = '$user_id' 
                 ORDER BY orders.created_at DESC";
$orders_result = mysqli_query($conn, $orders_query);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой профиль — Турагенство</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/profile_style.css">
</head>
<body>

<header>
    <div class="container header-inner">
        <div class="logo"><a href="index.php">Турагенство</a></div>
        <nav class="nav-menu">
            <ul>
                <li><a href="index.php">На главную</a></li>
                <li><a href="index.php#destinations">Все туры</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a>
        </div>
    </div>
</header>

<div class="container profile-wrapper">
    <!-- Левая колонка: Инфо о пользователе -->
    <aside class="profile-sidebar">
        <div class="user-info-card">
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3><?php echo htmlspecialchars($user_data['username']); ?></h3>
            <p class="user-email"><?php echo htmlspecialchars($user_data['email']); ?></p>
            <p class="reg-date">На сайте с <?php echo date('m.Y', strtotime($user_data['created_at'])); ?></p>
        </div>
        
        <nav class="profile-nav">
            <a href="#" class="active"><i class="fas fa-suitcase"></i> Мои поездки</a>
        </nav>
    </aside>

    
</div>

</body>
</html>
