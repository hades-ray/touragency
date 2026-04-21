<?php session_start(); 

require_once 'db.php'; // Подключаемся к базе

// Запрос на получение всех туров
$query = "SELECT * FROM tours";
$result = mysqli_query($conn, $query);

// 1. Получаем уникальные локации для фильтра
$locations_query = "SELECT DISTINCT location FROM tours";
$locations_result = mysqli_query($conn, $locations_query);

// 2. Получаем уникальные типы питания для фильтра
$diets_query = "SELECT DISTINCT diet FROM tours";
$diets_result = mysqli_query($conn, $diets_query);

// 3. Обработка фильтрации
$where_clauses = [];

if (!empty($_GET['filter_location'])) {
    $loc = mysqli_real_escape_string($conn, $_GET['filter_location']);
    $where_clauses[] = "location = '$loc'";
}

if (!empty($_GET['filter_diet'])) {
    $diet = mysqli_real_escape_string($conn, $_GET['filter_diet']);
    $where_clauses[] = "diet = '$diet'";
}

// Собираем итоговый SQL запрос
$sql = "SELECT * FROM tours";
if (count($where_clauses) > 0) {
    $sql .= " WHERE " . implode(' AND ', $where_clauses);
}

$tours_result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Турагенство</title>
    
    <!-- Подключаем внешние шрифты и иконки -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Подключаем наш файл стилей -->
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <header>
        <div class="container header-inner">
            <div class="logo">Турагенство</div>
            
            <nav class="nav-menu">
                <ul>
                    <li><a href="destinations_info.php">Направления</a></li>
                    <li><a href="services.php">Услуги</a></li>
                    <li><a href="reviews.php">Отзывы</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="tel:+79001234567" class="phone-num">+7 (900) 123-45-67</a>
                
                <?php if(isset($_SESSION['username'])): ?>
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="admin.php" class="admin-link" style="color: #ff6b6b; font-weight: bold; margin-right: 15px;">
                        <i class="fas fa-user-shield"></i> Админ-панель
                    </a>
                <?php endif; ?>
                    <a href="profile.php" class="user-btn">
                       <i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?>
                    </a>
                    <a href="logout.php" style="margin-left: 10px;"><i class="fas fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <a href="login.php" class="login-btn">Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <!-- Первый экран -->
        <section class="hero">
            <h1>Путешествия, которые остаются в сердце</h1>
            <p>Откройте для себя мир с экспертами в отдыхе</p>
            <a href="#destinations" class="cta-button">Начать подбор</a>
        </section>

        <!-- Секция направлений -->
        <section id="destinations" class="section container" style="padding-top: 100px;">
            <div class="section-title">
                <h2>Выберите ваше направление</h2>
                <p>Используйте фильтры, чтобы найти идеальный вариант</p>
            </div>
                        
            <!-- Форма фильтрации -->
            <div class="filter-bar">
                <form action="index.php#destinations" method="GET" class="filter-form">
                    <div class="filter-group">
                        <label>Направление:</label>
                        <select name="filter_location">
                            <option value="">Все страны</option>
                            <?php while($loc_row = mysqli_fetch_assoc($locations_result)): ?>
                                <option value="<?php echo $loc_row['location']; ?>" 
                                    <?php if(isset($_GET['filter_location']) && $_GET['filter_location'] == $loc_row['location']) echo 'selected'; ?>>
                                    <?php echo $loc_row['location']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                            
                    <div class="filter-group">
                        <label>Тип питания:</label>
                        <select name="filter_diet">
                            <option value="">Любое питание</option>
                            <?php while($diet_row = mysqli_fetch_assoc($diets_result)): ?>
                                <option value="<?php echo $diet_row['diet']; ?>"
                                    <?php if(isset($_GET['filter_diet']) && $_GET['filter_diet'] == $diet_row['diet']) echo 'selected'; ?>>
                                    <?php echo $diet_row['diet']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="search-btn">Применить фильтры</button>
                        <?php if(!empty($_GET)): ?>
                            <a href="index.php#destinations" class="reset-link">Сбросить</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Вывод карточек туров -->
            <div class="destinations-grid">
                <?php if (mysqli_num_rows($tours_result) > 0): ?>
                    <?php while($tour = mysqli_fetch_assoc($tours_result)): ?>
                        <div class="dest-card">
                            <div class="dest-img" style="background-image: url('img/tours/<?php echo $tour['image_file']; ?>')"></div>
                            <div class="dest-content">
                                <h3><?php echo htmlspecialchars($tour['title']); ?></h3>
                                <p><?php echo htmlspecialchars($tour['location']); ?></p>
                                <p style="font-size: 13px; color: #777;">
                                    <?php echo $tour['nights']; ?> ночей | <?php echo htmlspecialchars($tour['diet']); ?>
                                </p>
                                <div class="dest-price">от <?php echo number_format($tour['price'], 0, '', ' '); ?> ₽</div>
                                <a href="order.php?id=<?php echo $tour['id']; ?>" class="buy-btn">Забронировать</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                        <p>Туров с такими параметрами не найдено. Попробуйте изменить фильтры.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Блок преимуществ -->
        <section class="features">
            <div class="container feature-wrapper">
                <div class="feature-item">
                    <i class="fas fa-headset"></i>
                    <h3>Поддержка 24/7</h3>
                    <p>Мы на связи в любое время</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Надежность</h3>
                    <p>Только проверенные операторы</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-tags"></i>
                    <h3>Лучшие цены</h3>
                    <p>Прямые контракты с отелями</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-grid">
            <div class="footer-col">
                <div class="logo" style="color: white; margin-bottom: 20px;">Турагенство</div>
                <p>Ваш надежный гид в мире незабываемых путешествий. Работаем с 2015 года.</p>
                <div class="socials">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-telegram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Навигация</h4>
                <ul>
                    <li><a href="#">О компании</a></li>
                    <li><a href="#">Поиск туров</a></li>
                    <li><a href="#">Контакты</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Контакты</h4>
                <ul>
                    <li>г. Москва, ул. Пушкина, 10</li>
                    <li>info@travelworld.ru</li>
                    <li>8 (800) 555-35-35</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 Турагенство. Все права защищены.
        </div>
    </footer>

</body>
</html>