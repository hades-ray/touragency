<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Направления</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Сетка для блоков */
        .dest-info-grid { 
            display: flex; 
            flex-direction: column; 
            gap: 30px; 
            margin: 40px 0; 
        }

        /* Карточка направления */
        .dest-item { 
            display: flex; 
            gap: 30px; 
            background: #fff; 
            padding: 25px; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            align-items: flex-start; /* Выравнивание по верхнему краю */
            transition: transform 0.3s ease;
        }

        .dest-item:hover {
            transform: translateY(-5px);
        }

        /* Фиксация размеров изображения */
        .dest-image-wrapper {
            flex-shrink: 0; /* Запрещаем сжиматься контейнеру с фото */
            width: 350px;   /* Жесткая ширина для всех фото */
            height: 250px;  /* Жесткая высота для всех фото */
            overflow: hidden;
            border-radius: 15px;
        }

        .dest-image-wrapper img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; /* Фото обрезается под размер, а не растягивается */
        }

        /* Текстовая часть */
        .dest-text { 
            flex: 1; /* Занимает всё оставшееся пространство */
        }

        .dest-text h2 { 
            margin-top: 0;
            margin-bottom: 15px; 
            color: #2d3436; 
            font-size: 24px;
        }

        .dest-text p {
            color: #636e72;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .dest-tags { 
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag { 
            background: #eef2f7; 
            padding: 6px 15px; 
            border-radius: 25px; 
            font-size: 13px; 
            font-weight: 600;
            color: #007bff; 
        }

        /* Адаптивность для мобильных устройств */
        @media (max-width: 850px) {
            .dest-item {
                flex-direction: column; /* На телефонах картинка будет сверху, текст снизу */
            }
            .dest-image-wrapper {
                width: 100%; /* Фото на всю ширину экрана */
                height: 200px;
            }
        }
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
        <h1 style="text-align: center; margin-bottom: 10px;">Наши направления</h1>
        <p style="text-align: center; color: #666; margin-bottom: 50px;">Узнайте больше о странах, в которые мы организуем туры</p>

        <div class="dest-info-grid">
            
            <!-- Блок 1 -->
            <div class="dest-item">
                <div class="dest-image-wrapper">
                    <img src="img/tours/turkey.jpg" alt="Турция">
                </div>
                <div class="dest-text">
                    <h2>Турция — Между востоком и западом</h2>
                    <p>Турция предлагает бесконечное разнообразие: от лазурных берегов Антальи до сказочных дымоходов Каппадокии. Это страна, где античные руины соседствуют с современными курортами мирового уровня. Идеально подходит как для любителей системы "All Inclusive", так и для искателей приключений.</p>
                    <div class="dest-tags">
                        <span class="tag"><i class="fas fa-sun"></i> Пляжный отдых</span>
                        <span class="tag"><i class="fas fa-history"></i> Экскурсии</span>
                        <span class="tag"><i class="fas fa-utensils"></i> All Inclusive</span>
                    </div>
                </div>
            </div>

            <!-- Блок 2 -->
            <div class="dest-item">
                <div class="dest-image-wrapper">
                    <img src="img/tours/dubai.jpg" alt="ОАЭ">
                </div>
                <div class="dest-text">
                    <h2>ОАЭ — Оазис будущего</h2>
                    <p>Эмираты поражают воображение масштабами: самые высокие здания, самые большие торговые центры и роскошные искусственные острова. Здесь вас ждет безупречный сервис, сафари в пустыне и теплое море круглый год. Дубай и Абу-Даби — это города, которые нужно увидеть хотя бы раз в жизни.</p>
                    <div class="dest-tags">
                        <span class="tag"><i class="fas fa-city"></i> Небоскребы</span>
                        <span class="tag"><i class="fas fa-shopping-bag"></i> Шопинг</span>
                        <span class="tag"><i class="fas fa-star"></i> Премиум сервис</span>
                    </div>
                </div>
            </div>

            <!-- Блок 3 -->
            <div class="dest-item">
                <div class="dest-image-wrapper">
                    <img src="img/tours/thailand.jpg" alt="Таиланд">
                </div>
                <div class="dest-text">
                    <h2>Таиланд — Экзотика и гармония</h2>
                    <p>Таиланд — это страна вечного лета и искренних улыбок. Откройте для себя джунгли севера, шумные улицы Бангкока или безмятежные острова Пхукет и Самуи. Потрясающая кухня, знаменитый массаж и тропическая природа подарят вам полную перезагрузку.</p>
                    <div class="dest-tags">
                        <span class="tag"><i class="fas fa-palmtree"></i> Острова</span>
                        <span class="tag"><i class="fas fa-leaf"></i> Релакс</span>
                        <span class="tag"><i class="fas fa-pepper-hot"></i> Кухня</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>