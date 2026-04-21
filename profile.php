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

    <!-- Правая колонка: Список поездок -->
    <main class="profile-content">
        <section class="trips-section">
            <div class="section-header">
                <h2><i class="fas fa-map-marked-alt"></i> Мои поездки</h2>
                <span class="trips-count">Всего бронирований: <?php echo mysqli_num_rows($orders_result); ?></span>
            </div>

            <?php if (mysqli_num_rows($orders_result) > 0): ?>
                <div class="trips-list">
                    <?php while($order = mysqli_fetch_assoc($orders_result)): ?>
                        <div class="trip-card">
                            <div class="trip-img" style="background-image: url('img/tours/<?php echo $order['image_file']; ?>')">
                                <span class="trip-status">Подтверждено</span>
                            </div>
                            
                            <div class="trip-info">
                                <div class="trip-main">
                                    <h3><?php echo htmlspecialchars($order['title']); ?></h3>
                                    <p class="trip-loc"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($order['location']); ?></p>
                                    
                                    <div class="trip-dates">
                                        <div class="date-item">
                                            <span>Вылет:</span>
                                            <strong><?php echo date('d.m.Y', strtotime($order['start_date'])); ?></strong>
                                        </div>
                                        <div class="date-sep"><i class="fas fa-arrow-right"></i></div>
                                        <div class="date-item">
                                            <span>Возврат:</span>
                                            <strong><?php echo date('d.m.Y', strtotime($order['end_date'])); ?></strong>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="trip-side">
                                    <div class="trip-price">
                                        <span>Стоимость:</span>
                                        <strong><?php echo number_format($order['total_price'], 0, '', ' '); ?> ₽</strong>
                                    </div>
                                    <p class="order-id">ID брони: #<?php echo $order['id']; ?></p>
                                    <button class="btn-details">Детали ваучера</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <!-- Если поездок нет -->
                <div class="empty-state">
                    <img src="img/notrip.jpg" alt="No trips" width="120">
                    <h3>У вас пока нет забронированных туров</h3>
                    <p>Самое время отправиться в новое приключение!</p>
                    <a href="index.php#destinations" class="btn-primary">Посмотреть туры</a>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>

</body>
</html>