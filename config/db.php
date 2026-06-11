<?php
// Настройки подключения к Open Server
$host = '127.0.0.1';
$db   = 'zrd_mobile';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

// Формируем строку источника данных
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции для безопасной и удобной работы с БД
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Включает вывод ошибок, если что-то сломается
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Возвращает данные в виде удобных массивов
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Отключает эмуляцию запросов ради безопасности
];

try {
    // Создаем объект подключения к базе
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Если подключиться не удалось — выводим ошибку
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
