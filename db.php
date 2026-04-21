<?php
$host = 'localhost';
$user = 'root'; // Ваш логин БД
$pass = '';     // Ваш пароль БД
$dbname = 'travel_agency';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>