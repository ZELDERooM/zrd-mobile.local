<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Проверяем, что данные пришли именно методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Подключаем файл конфигурации базы данных
    require_once __DIR__ . '/../config/db.php';

    // 2. Получаем и бережно очищаем данные из формы
    $name  = trim(htmlspecialchars($_POST['name'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $phone = trim(htmlspecialchars($_POST['phone'] ?? ''));

    // Проверяем, что все поля заполнены
    if (empty($name) || empty($email) || empty($phone)) {
        http_response_code(400);
        echo "Пожалуйста, заполните все поля формы!";
        exit;
    }

    try {
        // 3. Готовим SQL-запрос для вставки данных в таблицу applications
        // Знаки вопроса — это плейсхолдеры для безопасной вставки данных
        $sql = "INSERT INTO applications (name, email, phone) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // 4. Выполняем запрос, передавая реальные переменные вместо знаков вопроса
        $stmt->execute([$name, $email, $phone]);

        // 5. Отправляем успешный ответ обратно в JavaScript
        echo "Спасибо, $name! Ваша заявка успешно сохранена в нашей базе данных. Мы свяжемся с вами по телефону $phone.";

    } catch (\PDOException $e) {
        // Если база данных выдала ошибку (например, опечатка в имени таблицы)
        http_response_code(500);
        echo "Ошибка при сохранении в базу данных: " . $e->getMessage();
    }

} else {
    // Если кто-то попытается открыть файл напрямую через браузер
    http_response_code(403);
    echo "Доступ запрещен.";
}
