<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

try {
    $stmt = $pdo->prepare("SELECT date, title, preview_text, image_path FROM faculty_news");
    $stmt->execute();
    $newsA = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
        $text = htmlspecialchars($row['preview_text'], ENT_QUOTES, 'UTF-8');
        $img = htmlspecialchars($row['image_path'], ENT_QUOTES, 'UTF-8');
        $date = htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8');

        $newsData = [
            'title' => $title,
            'text' => $text,
            'img' => $img,
            'date' => $date,
        ];

        $newsA[] = $newsData;
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo "Произошла ошибка при работе с базой данных. Пожалуйста, попробуйте позже.";
    exit;
}
?>

<div class="hnews__grid">
<?php foreach ($newsA as $i => $item):?>
    <div class="news-card">
        <div class="news-card__background">
            <img src="<?=$item['img']?>" alt="" class="news-card__image" aria-hidden="true">
        </div>
        <div class="news-card__content">
            <p class="news-card__date"><?=$item['date']?></p>
            <h1 class="news-card__title"><?=$item['title']?></h1>
            <p class="news-card__text"><?=$item['text']?></p>
        </div>
    </div>
<?php endforeach;?>
</div>