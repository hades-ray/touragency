<?php
session_start();
require_once 'db.php';

// 1. Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    // Если не авторизован, перенаправляем на логин с сообщением
    header("Location: login.php?msg=auth_required");
    exit();
}

// 2. Получение ID тура
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$tour_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// 3. Получение данных о туре
$query = "SELECT * FROM tours WHERE id = $tour_id";
$result = mysqli_query($conn, $query);
$tour = mysqli_fetch_assoc($result);

if (!$tour) {
    die("Тур не найден.");
}

$success_msg = "";

// 4. Обработка формы бронирования
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $nights = $tour['nights'];
    
    // Вычисление даты окончания
    $end_date = date('Y-m-d', strtotime($start_date . " + $nights days"));
    $total_price = $tour['price'];

    $sql = "INSERT INTO orders (user_id, tour_id, start_date, end_date, total_price) 
            VALUES ('$user_id', '$tour_id', '$start_date', '$end_date', '$total_price')";

    if (mysqli_query($conn, $sql)) {
        $success_msg = "Тур успешно забронирован! Мы свяжемся с вами в ближайшее время.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Бронирование: <?php echo $tour['title']; ?></title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/order_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header>
    <div class="container header-inner">
        <div class="logo"><a href="index.php">Турагенство</a></div>
        <div class="header-actions">
            <a href="profile.php" class="user-btn"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?></a>
        </div>
    </div>
</header>

<div class="container">
    <?php if ($success_msg): ?>
        <div class="success-banner">
            <h2><i class="fas fa-check-circle"></i> Поздравляем!</h2>
            <p><?php echo $success_msg; ?></p>
            <br>
            <a href="profile.php" class="login-btn">Перейти в мои поездки</a>
        </div>
    <?php else: ?>

    <div class="order-container">
        <!-- Левая часть: Описание тура -->
        <div class="tour-details">
            <img src="img/tours/<?php echo $tour['image_file']; ?>" class="tour-info-img">
            <h1><?php echo htmlspecialchars($tour['title']); ?></h1>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($tour['location']); ?></p>
            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">
            <p><strong>Длительность:</strong> <?php echo $tour['nights']; ?> ночей</p>
            <p><strong>Питание:</strong> <?php echo htmlspecialchars($tour['diet']); ?></p>
            <div class="price-tag"><?php echo number_format($tour['price'], 0, '', ' '); ?> ₽</div>
        </div>

        <!-- Правая часть: Форма -->
        <div class="order-form-box">
            <h2>Оформление заказа</h2>
            <p style="color: #666; margin-bottom: 20px;">Заполните данные для завершения бронирования</p>
            
            <form method="POST" class="order-form">
                <label>Выберите дату вылета:</label>
                <input type="date" name="start_date" id="start_date" required min="<?php echo date('Y-m-d'); ?>">
                
                <div class="calc-box" id="calc-result" style="display: none;">
                    <p>Продолжительность: <strong><?php echo $tour['nights']; ?> ночей</strong></p>
                    <p>Дата возвращения: <strong id="return_date">--</strong></p>
                </div>

                <button type="submit" class="login-btn" style="width: 100%; border: none; cursor: pointer;">
                    Подтвердить бронирование
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    // JavaScript для динамического расчета даты окончания на лету
    const startDateInput = document.getElementById('start_date');
    const returnDateSpan = document.getElementById('return_date');
    const calcBox = document.getElementById('calc-result');
    const nights = <?php echo $tour['nights']; ?>;

    startDateInput.addEventListener('change', function() {
        if (this.value) {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + nights);
            
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            returnDateSpan.innerText = endDate.toLocaleDateString('ru-RU', options);
            calcBox.style.display = 'block';
        }
    });
</script>

</body>
</html>