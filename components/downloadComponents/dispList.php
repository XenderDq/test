<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
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

// Инициализация массива ошибок
$errors = [];

// Получаем данные из POST
$group = trim($_POST['group'] ?? '');
$course = trim($_POST['course'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$discipline = trim($_POST['discipline'] ?? '');

// Проверка на пустоту
if (empty($group)) {
    $errors['group'] = 'Поле "Группа" не может быть пустым.';
}

if (empty($course)) {
    $errors['course'] = 'Поле "Курс" не может быть пустым.';
}

if (empty($subject)) {
    $errors['subject'] = 'Поле "Предмет" не может быть пустым.';
}

if (empty($discipline)) {
    $errors['discipline'] = 'Поле "Дисциплина" не может быть пустым.';
}

// Проверка формата данных
if (!empty($group) && !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $group)) {
    $errors['group'] = 'Название может содержать только буквы, цифры и символы: . , ! ? -';
}
if (!empty($course) && !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $course)) {
    $errors['course'] = 'Название может содержать только буквы, цифры и символы: . , ! ? -';
}
if (!empty($subject) && !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $subject)) {
    $errors['subject'] = 'Название может содержать только буквы, цифры и символы: . , ! ? -';
}
if (!empty($discipline) && !preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $discipline)) {
    $errors['discipline'] = 'Название может содержать только буквы, цифры и символы: . , ! ? -';
}

// Если есть ошибки - возвращаем их
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    // Получаем excell_code по группе
    $stmt = $pdo->prepare("SELECT excell_code FROM curriculum WHERE group_name = ?");
    $stmt->execute([$group]);
    $curriculum_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$curriculum_row) {
        throw new Exception('Excell code not found for group: ' . $group);
    }

    // Получаем путь к Excel-файлу
    $stmt = $pdo->prepare("SELECT excell_path FROM excell_files WHERE excell_code = ?");
    $stmt->execute([$curriculum_row['excell_code']]);
    $excell_file_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$excell_file_row) {
        throw new Exception('Excell path not found for code: ' . $curriculum_row['excell_code']);
    }
    
    $excell_path = $excell_file_row['excell_path'];

    // Получаем direction_code по группе
    $stmt = $pdo->prepare("SELECT direction_code FROM curriculum WHERE group_name = ? LIMIT 1");
    $stmt->execute([$group]);
    $direction_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$direction_row) {
        throw new Exception('Direction not found for group: ' . $group);
    }

    // Получаем уровень образования по direction_code
    $stmt = $pdo->prepare("SELECT level_of_education_code FROM directions WHERE code = ?");
    $stmt->execute([$direction_row['direction_code']]);
    $level_row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$level_row) {
        throw new Exception('Education level not found for direction: ' . $direction_row['direction_code']);
    }

    // Получаем учебные материалы
    $sql = "SELECT
                type_file_discipline,
                file_discipline_name,
                file_path
            FROM academic_material
            WHERE
                direction_code = :direction_code AND
                level_of_education_code = :level_code AND
                course = :course AND
                disciplines_name = :subject AND
                type_file_discipline = :discipline";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':direction_code' => $direction_row['direction_code'],
        ':level_code' => $level_row['level_of_education_code'],
        ':course' => $course,
        ':subject' => $subject,
        ':discipline' => $discipline
    ]);

    $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        'success' => true,
        'excell_path' => $excell_path,
        'groupName' => $group,
        'materials' => $materials ?: []
    ];

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

exit;
?>