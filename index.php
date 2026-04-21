<?php session_start(); 

require_once 'db.php'; // Подключаемся к базе

// Запрос на получение всех туров
$query = "SELECT * FROM tours";
$result = mysqli_query($conn, $query);
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
                    <li><a href="#destinations">Направления</a></li>
                    <li><a href="#services">Услуги</a></li>
                    <li><a href="#reviews">Отзывы</a></li>
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

        <!-- Модуль поиска -->
        <div class="container">
            <form class="search-box">
                <div class="search-group">
                    <label>Куда едем?</label>
                    <select>
                        <option>Турция</option>
                        <option>ОАЭ</option>
                        <option>Египет</option>
                        <option>Таиланд</option>
                    </select>
                </div>
                <div class="search-group">
                    <label>Дата вылета</label>
                    <input type="date">
                </div>
                <div class="search-group">
                    <label>Туристы</label>
                    <input type="number" value="2" min="1">
                </div>
                <button type="submit" class="search-btn">Найти туры</button>
            </form>
        </div>

        <!-- Секция направлений -->
        <section id="destinations" class="section container">
            <div class="section-title">
                <h2>Популярные направления</h2>
                <p>Лучшие предложения по мнению наших туристов</p>
            </div>

            <div class="destinations-grid">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($tour = mysqli_fetch_assoc($result)): ?>
                        <!-- Начало карточки тура -->
                        <div class="dest-card">
                            <div class="dest-img" style="background-image: url('img/tours/<?php echo $tour['image_file']; ?>')">
                                <!-- Здесь картинка берется из локальной папки -->
                            </div>
                            <div class="dest-content">
                                <h3><?php echo htmlspecialchars($tour['title']); ?></h3>
                                <p><?php echo htmlspecialchars($tour['location']); ?></p>
                                <p style="font-size: 0.9em; color: #777;">
                                    <i class="far fa-moon"></i> <?php echo $tour['nights']; ?> ночей | 
                                    <i class="fas fa-utensils"></i> <?php echo htmlspecialchars($tour['diet']); ?>
                                </p>
                                <div class="dest-price">от <?php echo number_format($tour['price'], 0, '', ' '); ?> ₽</div>
                                <a href="order.php?id=<?php echo $tour['id']; ?>" class="buy-btn">Забронировать</a>
                            </div>
                        </div>
                        <!-- Конец карточки тура -->
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>К сожалению, туров пока нет.</p>
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