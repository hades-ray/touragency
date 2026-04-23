<?php
session_start();
require_once 'db.php';

// Проверка: админ ли это?
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$msg = "";

// 1. Логика добавления нового тура
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tour'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = intval($_POST['price']);
    $nights = intval($_POST['nights']);
    $diet = $_POST['diet'];

    $target_dir = "img/tours/";
    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO tours (title, location, price, nights, diet, image_file) 
                VALUES ('$title', '$location', '$price', '$nights', '$diet', '$file_name')";
        if (mysqli_query($conn, $sql)) {
            $msg = "<p class='success'>Тур успешно добавлен!</p>";
        }
    } else {
        $msg = "<p class='error'>Ошибка при загрузке картинки.</p>";
    }
}

// 2. Получение списка всех бронирований
$orders_query = "SELECT orders.*, users.username, users.email, tours.title AS tour_title 
                 FROM orders 
                 JOIN users ON orders.user_id = users.id 
                 JOIN tours ON orders.tour_id = tours.id 
                 ORDER BY orders.created_at DESC";
$orders_result = mysqli_query($conn, $orders_query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель — Управление турами и бронями</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; }
        .admin-wrapper { max-width: 1100px; margin: 40px auto; display: grid; grid-template-columns: 300px 1fr; gap: 30px; }
        
        /* Боковая панель управления */
        .admin-sidebar { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); height: fit-content; }
        .admin-nav button { width: 100%; text-align: left; padding: 12px; margin-bottom: 10px; border: none; background: none; font-size: 16px; cursor: pointer; border-radius: 8px; transition: 0.3s; }
        .admin-nav button:hover, .admin-nav button.active { background: #007bff; color: white; }

        /* Контентные блоки */
        .admin-content-section { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .hidden { display: none; }

        /* Стили формы */
        .admin-form input, .admin-form select { width: 100%; padding: 12px; margin: 10px 0 20px; border: 1px solid #ddd; border-radius: 8px; }
        .btn-add { background: #2ecc71; color: white; border: none; padding: 15px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; }

        /* Стили таблицы заказов */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        table th { background: #f8f9fa; text-align: left; padding: 12px; border-bottom: 2px solid #dee2e6; }
        table td { padding: 12px; border-bottom: 1px solid #eee; }
        .status-badge { background: #e1fcef; color: #14804a; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        
        .success { color: #2ecc71; font-weight: bold; }
        .error { color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>

<header>
    <div class="container header-inner">
        <div class="logo">Панель администратора</div>
        <a href="index.php" style="color: #007bff; text-decoration: none;"><i class="fas fa-home"></i> На главную сайта</a>
    </div>
</header>



<script>
    // Простой скрипт для переключения вкладок
    function showSection(sectionId) {
        // Скрываем все секции
        document.getElementById('section-orders').classList.add('hidden');
        document.getElementById('section-add-tour').classList.add('hidden');
        
        // Убираем активный класс у кнопок
        document.getElementById('btn-orders').classList.remove('active');
        document.getElementById('btn-add-tour').classList.remove('active');

        // Показываем нужную секцию
        document.getElementById('section-' + sectionId).classList.remove('hidden');
        
        // Делаем кнопку активной
        document.getElementById('btn-' + sectionId).classList.add('active');
    }
</script>

</body>
</html>
