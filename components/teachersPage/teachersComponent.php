
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';
    try {
        $stmt = $pdo->prepare("SELECT department_code,full_name, info, image_path, post FROM teachers");
        $stmt->execute();
        $teachersA = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $code  = htmlspecialchars($row['department_code'], ENT_QUOTES, 'UTF-8');
            $name  = htmlspecialchars($row['full_name'],       ENT_QUOTES, 'UTF-8');
            $info  = htmlspecialchars($row['info'],            ENT_QUOTES, 'UTF-8');
            $pic   = htmlspecialchars($row['image_path'],      ENT_QUOTES, 'UTF-8');
            $post  = htmlspecialchars($row['post'],            ENT_QUOTES, 'UTF-8');

            $teacherData = [
                'code'      =>$code,
                'full_name' => $name,
                'info'      => $info,
                'image'     => $pic,
                'post'      => $post,
            ];
            $teachersA[] = $teacherData;
        }
    } 
    catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        echo "Произошла ошибка при работе с базой данных.";
        exit;
    }
?>
                    <div class="content-block active" data-content="all">
                        <?php foreach($teachersA as $code => $item):?>
                            <div class="content-block-item" data-categories="<?=$item['code']?>">
                                <div class="content-img">
                                    <img src="<?=$item['image']?>" alt="" class="img_filter">
                                </div>
                                <div class="content-block-item__text">
                                    <h1 class="name_title_teach"><?=$item['full_name']?></h1>
                                    <p class="name_text_teach"><?=$item['post']?></p>
                                    <p class="name_text_teach--text"><?=$item['info']?></p>
                                </div>
                            </div>
                        <?php endforeach?>
                    </div>