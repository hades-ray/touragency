<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отзывы клиентов</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .reviews-container { max-width: 800px; margin: 40px auto; }
        .review-item { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px; position: relative; }
        .review-item::before { content: "\f10d"; font-family: "Font Awesome 5 Free"; font-weight: 900; position: absolute; top: 20px; left: -15px; font-size: 30px; color: #007bff; opacity: 0.2; }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .review-author { font-weight: bold; font-size: 18px; }
        .stars { color: #f1c40f; }
        .review-date { color: #aaa; font-size: 12px; }
        .review-tour { font-style: italic; color: #007bff; margin-bottom: 10px; display: block; }
    </style>
</head>
<body>
    <header>
        <div class="container header-inner">
            <div class="logo"><a href="index.php">Турагенство</a></div>
            
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
    <div class="container section">
        <h1 style="text-align: center; margin-bottom: 50px;">Что о нас говорят путешественники</h1>
        
        <div class="reviews-container">
            <div class="review-item">
                <div class="review-header">
                    <span class="review-author">Екатерина Волкова</span>
                    <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <span class="review-tour">Тур: "Дубай — Золотой песок", Октябрь 2024</span>
                <p>Огромное спасибо за отличный отпуск! Менеджер подобрала отель точно под наш бюджет. Весь пакет документов прислали вовремя, на все вопросы отвечали моментально.</p>
                <span class="review-date">15.11.2024</span>
            </div>

            <div class="review-item">
                <div class="review-header">
                    <span class="review-author">Александр Морозов</span>
                    <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                </div>
                <span class="review-tour">Тур: "Анталья — Все включено", Июль 2024</span>
                <p>Все прошло гладко. Трансфер встретил с табличкой, отель соответствовал описанию на сайте. Немного задержали рейс, но агентство предупредило заранее, так что в аэропорту лишнего времени не провели.</p>
                <span class="review-date">20.08.2024</span>
            </div>

            <div class="review-item" style="text-align: center; background: #f0f7ff; border: 2px dashed #007bff;">
                <h3>Хотите оставить свой отзыв?</h3>
                <p>Ваше мнение очень важно для нас. Отправьте ваш отзыв на почту <strong>reviews@travelworld.ru</strong></p>
            </div>
        </div>
    </div>
</body>
</html>