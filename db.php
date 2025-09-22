<?php
// Настройки подключения к БД
$host    = 'localhost';              // Адрес сервера
$db      = 'davosa3h_univers';      // Имя базы данных
$user    = 'davosa3h_univers';      // Логин пользователя
$pass    = '4X#5fu55&DO%';           // Пароль
$charset = 'utf8mb4';               // Кодировка

// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции подключения
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Ошибки через исключения
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Получение ассоциативных массивов
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Использовать реальные подготовленные выражения
];

try {
    // Создание подключения
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Обработка ошибки подключения
    http_response_code(500);
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit;
}


