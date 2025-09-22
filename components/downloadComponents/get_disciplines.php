<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_disciplines') {
    $group = $_GET['group'] ?? '';
    $course = $_GET['course'] ?? '';

    $response = ['disciplines' => [], 'error' => ''];
    
    if (!empty($group) && !empty($course)) {
        try {
            // Получаем direction_code для группы
            $stmt = $pdo->prepare("SELECT direction_code FROM curriculum WHERE group_name = ?");
            $stmt->execute([$group]);
            $curriculum = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($curriculum) {
                $direction_code = $curriculum['direction_code'];
                
                // Получаем дисциплины
                $stmt = $pdo->prepare("SELECT DISTINCT disciplines_name 
                                      FROM academic_material 
                                      WHERE direction_code = ? AND course = ? 
                                      ORDER BY disciplines_name");
                $stmt->execute([$direction_code, $course]);
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $response['disciplines'][] = htmlspecialchars($row['disciplines_name'], ENT_QUOTES, 'UTF-8');
                }
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
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}