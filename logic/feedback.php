<?php
header('Content-Type: application/json; charset=UTF-8');
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
      'success' => false,
      'message' => 'Неверный метод запроса'
    ]);
    exit;
}


$name   = trim($_POST['name']   ?? '');
$tel    = trim($_POST['tel']    ?? '');
$email  = trim($_POST['email']  ?? '');
$tellus = trim($_POST['tellus'] ?? '');

$errors = [];

// 1) Проверка ФИО (хотя фронтенд уже ограничивает, но проверим)
if ($name === '' || !preg_match('/^[А-ЯЁ][а-яё]+\s[А-ЯЁ][а-яё]+(\s[А-ЯЁ][а-яё]+)?$/u', $name)) {
    $errors['name'] = 'Введите корректное ФИО (например, Иванов Иван).';
}

if (!preg_match('/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/', $tel)) {
    $errors['tel'] = 'Телефон в формате +7 (XXX) XXX-XX-XX.';
}

// 3) Email
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Введите корректный E-mail.';
}

// 4) Сообщение
if (empty($tellus)) {
    $errors['tellus'] = 'Сообщение не может быть пустым.';
} 
if (mb_strlen($tellus) > 1000) {
    $errors['tellus'] = 'Сообщение слишком длинное (макс. 1000 символов).';
}
if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $tellus)) {
    $errors['tellus'] = 'Сообщение может содержать только буквы, цифры и символы: . , ! ? -';
}

// Если есть ошибки — отдадим их
if ($errors) {
    echo json_encode([
      'success' => false,
      'message' => $errors['name'] . ' ' . $errors['tel'] . ' ' . $errors['email'] . ' ' . $errors['tellus'],
      'errors'  => $errors
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO feedback (applicants_name, phone_number, email, preview_text) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $tel, $email, $tellus]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Спасибо! Мы с вами обязательно свяжемся.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Не удалось сохранить данные. Попробуйте ещё раз.'
        ]);
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Произошла ошибка сервера. Попробуйте позже.'
    ]);
}
exit;