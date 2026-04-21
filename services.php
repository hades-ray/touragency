<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Наши услуги</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .services-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px; }
        .service-card { background: #fff; padding: 40px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 4px solid #007bff; }
        .service-card i { font-size: 40px; color: #007bff; margin-bottom: 20px; }
        .service-card h3 { margin-bottom: 15px; }
        .service-card p { color: #777; font-size: 14px; }
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
        <h1 style="text-align: center;">Чем мы можем быть полезны</h1>
        <div class="services-list">
            <div class="service-card">
                <i class="fas fa-passport"></i>
                <h3>Визовая поддержка</h3>
                <p>Оформляем шенгенские и другие визы в кратчайшие сроки. Поможем с анкетами и записью в консульства.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-user-shield"></i>
                <h3>Страхование</h3>
                <p>Ваша безопасность — наш приоритет. Оформляем расширенную медицинскую страховку и страховку от невыезда.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-plane-arrival"></i>
                <h3>V.I.P. Трансфер</h3>
                <p>Индивидуальные встречи в аэропорту на автомобилях бизнес-класса. С комфортом доставим вас до дверей отеля.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-briefcase"></i>
                <h3>MICE услуги</h3>
                <p>Организуем корпоративные поездки, конференции и тимбилдинги в любой стране мира для вашего бизнеса.</p>
            </div>
        </div>
    </div>
</body>
</html>