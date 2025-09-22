<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit('Method Not Allowed');
}

// Проверка на пустые значения
if (empty($_POST['username']) || empty($_POST['password'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Заполните все поля'
    ]);
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

$login = trim($_POST['username']);
$password = $_POST['password'];

try {
    // Ищем пользователя по логину (подготовленное выражение)
    $stmt = $pdo->prepare('SELECT * FROM users WHERE login = :login');
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Проверяем существование пользователя и соответствие пароля
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['root'] = $user['root'];
        
        echo json_encode([
            'success' => true,
            'redirect' => '/'
        ]);
        exit;
    }
    
    // Неверные данные
    echo json_encode([
        'success' => false,
        'error' => 'Неверный логин или пароль'
    ]);
    exit;
    
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Ошибка сервера'
    ]);
    exit;
}