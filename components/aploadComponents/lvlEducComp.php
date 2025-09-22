<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

try {
    $stmt = $pdo->prepare("SELECT code, name FROM levels_of_education");
    $stmt->execute();
    $levels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $lvlA = array_column($levels, 'name');
    
    $stmt = $pdo->prepare("
        SELECT d.name, d.count_of_courses, d.level_of_education_code 
        FROM directions d
    ");
    $stmt->execute();
    $directions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $educationData = [];
    foreach ($levels as $level) {
        $levelCode = $level['code'];
        $educationData[$levelCode] = [
            'name' => $level['name'],
            'directions' => []
        ];
        
        foreach ($directions as $direction) {
            if ($direction['level_of_education_code'] == $levelCode) {
                $educationData[$levelCode]['directions'][$direction['name']] = 
                    (int)$direction['count_of_courses'];
            }
        }
    }
    $educationJson = json_encode($educationData);
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo "Произошла ошибка при работе с базой данных. Пожалуйста, попробуйте позже.";
    exit;
}

?>

<script>
    const educationData = <?= $educationJson ?>;
</script>

<div class="education">
    <p class="upload_lebel" typ="upload_lebel">Уровень образования</p>
    <select name="education" required id="education">
        <option value="" disabled selected hidden>Выберите уровень образования...</option>
        <?php foreach ($lvlA as $item): ?>
            <option value="<?= $item ?>"><?= $item ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="first_upload_select">
    <div class="direction">
        <p class="upload_lebel" typ="upload_lebel">Направление</p>
        <select name="direction" required id="direction" disabled>
            <option value="" disabled selected hidden>Выберите направление...</option>
        </select>
    </div>
    <div class="course">
        <p class="upload_lebel" typ="upload_lebel">Курс</p>
        <select name="course" required id="course" disabled>
            <option value="" disabled selected hidden>Выберите курс...</option>
        </select>
    </div>
</div>
