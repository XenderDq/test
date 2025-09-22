<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

try {
    $stmt = $pdo->prepare("SELECT code, name FROM levels_of_education");
    $stmt->execute();
    $eduLvl = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $code = htmlspecialchars($row['code'], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $eduLvl[$code] = $name;
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo "Произошла ошибка при работе с базой данных.";
    exit;
}

  try {
        $stmt = $pdo->prepare("SELECT  level_of_education_code, name, info, cost FROM directions");
        $stmt->execute();
        $directionsA = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $code  = htmlspecialchars($row['level_of_education_code'], ENT_QUOTES, 'UTF-8');
            $name  = htmlspecialchars($row['name'],       ENT_QUOTES, 'UTF-8');
            $info  = htmlspecialchars($row['info'],            ENT_QUOTES, 'UTF-8');
            $cost   = htmlspecialchars($row['cost'],          ENT_QUOTES, 'UTF-8');
        
            $directionsData = [
                'code'      =>$code,
                'name'      => $name,
                'info'     => $info,
                'cost'      => $cost,
            ];
            $directionsA[]= $directionsData;
        }
    } 
    catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        echo "Произошла ошибка при работе с базой данных.";
        exit;
    }
?>
<div class="show_content_aplicants-item" data-categories-apl="aplicant-item">
            <div class="content_aplicant-first">
                <div class="aplicant_top-tittle">
                    <h1 class="aplicant_top-tittle-text">Уровни Обучения</h1>
                </div>
                <div class="aplicant-tabs">
                    <button class="aplicant-tab active" data-tab="all">Все</button>
                    <?php foreach ($eduLvl as $code =>$item):?>
                    <button class="aplicant-tab" data-tab="<?=$code?>"><?=$item?></button>
                   <?php endforeach;?>
                </div>

                <div class="aplicant-content">
                    <div class="aplicant_tab-items active" data-content="all">
                    <?php foreach ($directionsA as $code =>$item):?>
                        <div class="aplicant_tab-item" data-categories="<?=$item['code']?>">
                            <div class="aplicant_tabitem__text-info">
                                <h1 class="aplicant_tab-title"><?=$item['name']?></h1>
                                <p class="aplicant_tab-text-description"><?=$item['info']?></p>
                            </div>
                            <div class="aplicant_tabitem__text-price">
                                <h1 class="aplicant_tab_title-price">Стоимость: </h1>
                                <p class="aplicant_tab-text-price" value="<?=$item['cost']?>"></p>
                            </div>
                        </div> 
                        <?php endforeach;?>
                    </div>
                </div>

            </div>
            <div class="content_aplicant-second">
                <div class="aplicant_bottom-tittle">
                    <h1 class="aplicant_bottom-tittle-text">Форма обучения</h1>
                </div>
                <div class="aplicant_type_educ-items">
                    <div class="aplicant_educ-item">
                        <div class="aplicant_educ-item-title">Очная</div>
                        <div class="aplicant_educ-item-text">
                            Классическая форма обучения с ежедневным посещением занятий в вузе. 
                            Предусматривает максимальный объём аудиторной работы, личный контакт 
                            с преподавателями и участие в научной/студенческой жизни. Подходит для 
                            абитуриентов, готовых посвятить учёбе основное время.
                        </div>
                    </div>
                    <div class="aplicant_educ-item">
                        <div class="aplicant_educ-item-title">Заочная </div>
                        <div class="aplicant_educ-item-text">
                            Обучение с самостоятельным освоением материала. Занятия проходят 
                            сессиями 2 раза в год (установочная и экзаменационная). Позволяет 
                            совмещать учёбу с работой. Требует высокой самоорганизации и подходит 
                            для работающих студентов.
                        </div>
                    </div>
                    <div class="aplicant_educ-item">
                        <div class="aplicant_educ-item-title">Очно-Заочная</div>
                        <div class="aplicant_educ-item-text">
                            Гибкий формат (вечернее обучение). Занятия проходят 3-4 раза в неделю 
                            после 18:00 или в выходные. Сочетает регулярный контакт с преподавателями 
                            и возможность работать днём. Интенсивность ниже, чем на очной форме.
                        </div>
                    </div>
                    <div class="aplicant_educ-item">
                        <div class="aplicant_educ-item-title">Дистанционная</div>
                        <div class="aplicant_educ-item-text">
                            Обучение через онлайн-платформы без физического присутствия в вузе. 
                            Включает видеолекции, вебинары, электронные тесты и консультации 
                            по интернету. Требует наличия компьютера и интернета. Максимально гибкий 
                            график, подходит для жителей других городов/стран.
                        </div>
                    </div>  
                </div>
            </div> 
        </div>