<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

try {
    $stmt = $pdo->prepare("SELECT code, name FROM departments");
    $stmt->execute();
    $departments = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $code = htmlspecialchars($row['code'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $departments[$code] = $name;
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo "Произошла ошибка при работе с базой данных.";
    exit;
}
?>
<div class="filter-tabs">
    <button class="filter-tab active" data-tab="all">Все</button>
    <?php foreach ($departments as $code => $name): ?>
        <button class="filter-tab" data-tab="<?=$code?>"><?=$name?></button>
    <?php endforeach; ?>
</div>
