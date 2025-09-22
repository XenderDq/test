<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

// Обработка AJAX-запросов
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $response = [];
    
    // Запрос списка групп
    if ($_GET['action'] === 'get_groups') {
        try {
            $stmt = $pdo->query("SELECT DISTINCT group_name FROM curriculum ORDER BY group_name");
            $groups = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $groups[] = htmlspecialchars($row['group_name'], ENT_QUOTES, 'UTF-8');
            }
            $response['groups'] = $groups;
        } catch (PDOException $e) {
            error_log("DB Error: " . $e->getMessage());
            $response['error'] = 'Ошибка базы данных';
        }
    }

// Новый обработчик для получения количества курсов
elseif ($_GET['action'] === 'get_course_count') {
    $group = $_GET['group'] ?? '';
    
    $response = ['count' => 0, 'error' => ''];
    
    if (!empty($group)) {
        try {
            // 1. Получаем direction_code для группы
            $stmt = $pdo->prepare("SELECT direction_code FROM curriculum WHERE group_name = ?");
            $stmt->execute([$group]);
            $curriculum = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($curriculum) {
                $direction_code = $curriculum['direction_code'];
                
                // 2. Получаем количество курсов для направления
                $stmt = $pdo->prepare("SELECT count_of_courses FROM directions WHERE code = ?");
                $stmt->execute([$direction_code]);
                $direction = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($direction) {
                    $response['count'] = (int)$direction['count_of_courses'];
                } else {
                    $response['error'] = 'Направление не найдено';
                }
            } else {
                $response['error'] = 'Группа не найдена';
            }
        } catch (PDOException $e) {
            error_log("DB Error: " . $e->getMessage());
            $response['error'] = 'Ошибка базы данных';
        }
    } else {
        $response['error'] = 'Не указана группа';
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

    // Запрос списка дисциплин
    elseif ($_GET['action'] === 'get_disciplines') {
        $group = $_GET['group'] ?? '';
        $course = $_GET['course'] ?? '';

        if (!empty($group) && !empty($course)) {
            try {
                $stmt = $pdo->prepare("SELECT direction_code FROM curriculum WHERE group_name = ?");
                $stmt->execute([$group]);
                $curriculum = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($curriculum) {
                    $direction_code = $curriculum['direction_code'];
                    
                    $stmt = $pdo->prepare("SELECT DISTINCT disciplines_name 
                                          FROM academic_material 
                                          WHERE direction_code = ? AND course = ? 
                                          ORDER BY disciplines_name");
                    $stmt->execute([$direction_code, $course]);
                    
                    $disciplines = [];
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $disciplines[] = htmlspecialchars($row['disciplines_name'], ENT_QUOTES, 'UTF-8');
                    }
                    $response['disciplines'] = $disciplines;
                } else {
                    $response['error'] = 'Группа не найдена';
                }
            } catch (PDOException $e) {
                error_log("DB Error: " . $e->getMessage());
                $response['error'] = 'Ошибка базы данных';
            }
        } else {
            $response['error'] = 'Не указана группа или курс';
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<datalist id="group-list"></datalist>

<div class="subject">
    <p class="upload_lebel" typ="upload_lebel">Предмет</p>
    <select name="subject" required id="subject" disabled>
        <option value="" disabled selected hidden>Сначала выберите группу и курс</option>
    </select>
</div>

