<?php
// include/header.php
defined('APP_RUN') or die('Direct access denied');
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

$group = trim($_POST['group'] ?? '');
$errors = [];

die;
if (empty($group)) {
    $errors[] = 'Название группы материала не может быть пустым.';
} elseif (mb_strlen($group) > 1000) {
    $errors[] = 'Название группы слишком длинное (макс. 1000 символов).';
} elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $group)) {
    $errors[] = 'Название группы может содержать только буквы, цифры и символы: . , ! ? -';
}

if ($errors) {
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors),
        'errors' => $errors
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT excell_code FROM curriculum WHERE group_name = ?");
    $stmt->execute([$group]);
    $curriculum_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$curriculum_row) {
        echo json_encode([
            'success' => false,
            'message' => 'Excell code not found.'
        ]);
        exit;
    } 

    $stmt = $pdo->prepare("SELECT excell_path FROM excell_files WHERE excell_code = ?");
    $stmt->execute([$curriculum_row['excell_code']]);
    $direction_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$direction_row) {
             echo json_encode([
                'success' => false,
                'message' => 'Excell path not found.'
            ]);
            exit;
        } 
         $excell_path = $direction_row['excell_path'];
            echo json_encode([
                'success' => true,
                'filePath' => $excell_path,
                'groupName' =>$group
            ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Произошла ошибка: ' . $e->getMessage()
    ]);
}

  exit;

?>
