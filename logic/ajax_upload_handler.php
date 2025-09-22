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

// Получаем данные
$file = $_FILES['file'] ?? null;
$education = trim($_POST['education'] ?? '');
$direction = trim($_POST['direction'] ?? '');
$course = trim($_POST['course'] ?? '');
$discipline = trim($_POST['discipline_class'] ?? '');
$typeofdisc = trim($_POST['typeofdisc'] ?? '');
$material = trim($_POST['material'] ?? '');

$errors = [];

// === Валидация названия материала ===
if (empty($material)) {
    $errors['material'] = 'Название материала не может быть пустым.';
} elseif (mb_strlen($material) > 1000) {
    $errors['material'] = 'Название слишком длинное (макс. 1000 символов).';
} elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $material)) {
    $errors['material'] = 'Название может содержать только буквы, цифры и символы: . , ! ? -';
}
if (empty($discipline)) {
    $errors['discipline_class'] = 'Название дисциплины не может быть пустым.';
} elseif (mb_strlen($discipline) > 1000) {
    $errors['discipline_class'] = 'Название слишком длинное (макс. 1000 символов).';
} elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\s.,!?-]+$/u', $discipline)) {
    $errors['discipline_class'] = 'Название может содержать только буквы, цифры и символы: . , ! ? -';
}

// === Валидация файла ===
if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    $errors['file'] = 'Файл не был загружен или произошла ошибка.';
} else {
    $allowedExt = ['pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'ppt', 'pptx'];
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedExt)) {
        $errors['file'] = 'Недопустимый тип файла. Разрешены: pdf, doc, docx, txt, xls, xlsx, ppt, pptx';
    }

    if ($fileSize > 10 * 1024 * 1024) { // 10 МБ
        $errors['file'] = 'Файл слишком большой. Максимальный размер — 10 МБ.';
    }
}

if ($errors) {
    echo json_encode([
        'success' => false,
        'message' => implode(' ', $errors),
        'errors' => $errors
    ]);
    exit;
}

// Формируем имя файла на основе данных
$safeDiscipline = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $discipline);
$safeType = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $typeofdisc);
$safeMaterial = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $material);

// Заменяем пробелы на подчеркивания и обрезаем
$safeDiscipline = mb_substr(str_replace(' ', '_', $safeDiscipline), 0, 50);
$safeType = mb_substr(str_replace(' ', '_', $safeType), 0, 50);
$safeMaterial = mb_substr(str_replace(' ', '_', $safeMaterial), 0, 50);

// Ограничиваем длину с учетом многобайтовых символов
$safeDiscipline = mb_substr($safeDiscipline, 0, 30, 'UTF-8');
$safeType = mb_substr($safeType, 0, 20, 'UTF-8');
$safeMaterial = mb_substr($safeMaterial, 0, 30, 'UTF-8');

// Собираем базовое имя файла
$baseName = $safeDiscipline . '_' . $safeType . '_' . $safeMaterial;
if (empty($baseName)) $baseName = 'material';

// Генерируем уникальное имя файла (с ограничением длины)
$uniquePart = uniqid();
$fileNameBase = $baseName . '_' . $uniquePart;
$newFileName = mb_substr($fileNameBase, 0, 200, 'UTF-8') . '.' . $fileExt;

// Измененный путь к директории загрузки
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'; 

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        echo json_encode([
            'success' => false,
            'message' => 'Не удалось создать директорию для загрузки'
        ]);
        exit;
    }
}

$destination = $uploadDir . $newFileName;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    echo json_encode([
        'success' => false,
        'message' => 'Не удалось сохранить файл.'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT code FROM levels_of_education WHERE name = ?");
    $stmt->execute([$education]);
    $level = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$level) {
        throw new Exception("Уровень образования не найден");
    }
    $level_code = $level['code'];

    // Получаем код направления (с привязкой к уровню)
    $stmt = $pdo->prepare("SELECT code FROM directions WHERE name = ? AND level_of_education_code = ?");
    $stmt->execute([$direction, $level_code]);
    $direction_row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$direction_row) {
        throw new Exception("Направление не найдено для выбранного уровня");
    }
    $direction_code = $direction_row['code'];

    $stmt = $pdo->prepare("
        INSERT INTO academic_material (
            level_of_education_code,
            direction_code,
            course,
            disciplines_name,
            type_file_discipline,
            file_discipline_name,
            file_path
        ) VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $level_code,
        $direction_code,
        $course,
        $discipline,
        $typeofdisc,
        $material,
        '/uploads/' . $newFileName
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Материал успешно загружен!'
    ]);

} 
catch (Exception $e) {
    // Удаляем файл при ошибке БД
    if (file_exists($destination)) {
        unlink($destination);
    }
    
    echo json_encode([
        'success' => false,
        'message' => 'Ошибка базы данных: ' . $e->getMessage()
    ]);
}
?>