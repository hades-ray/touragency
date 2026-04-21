CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `tour_id` (`tour_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`id`, `user_id`, `tour_id`, `start_date`, `end_date`, `total_price`, `created_at`) VALUES
(1, 1, 1, '2026-04-21', '2026-04-28', 45000, '2026-04-21 03:48:06'),
(2, 1, 1, '2026-04-21', '2026-04-28', 45000, '2026-04-21 03:48:28'),
(3, 2, 2, '2026-04-22', '2026-04-28', 125000, '2026-04-21 04:44:11');

CREATE TABLE IF NOT EXISTS `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `nights` int(11) NOT NULL,
  `diet` varchar(50) DEFAULT 'Все включено',
  `image_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tours` (`id`, `title`, `location`, `price`, `nights`, `diet`, `image_file`) VALUES
(1, 'Отель Sea View 5*', 'Турция, Анталья', 45000, 7, 'Все включено', 'turkey.jpg'),
(2, 'Burj Al Arab Luxury', 'ОАЭ, Дубай', 125000, 6, 'Завтраки', 'dubai.jpg'),
(3, 'Phuket Garden Resort', 'Таиланд, Пхукет', 82000, 10, 'Без питания', 'thailand.jpg'),
(4, 'Pyramids Plaza', 'Египет, Хургада', 52000, 7, 'Все включено', 'egypt.jpg');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(10) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'hadesray', 'hadesray@yandex.ru', '1234', '2026-04-21 03:00:50', 'user'),
(2, 'admin', 'admin@travelworld.ru', 'Qaz12345', '2026-04-21 04:50:55', 'admin');

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`);
COMMIT;