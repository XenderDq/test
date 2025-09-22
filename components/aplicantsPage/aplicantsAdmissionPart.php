<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

try {
    $stmt = $pdo->prepare("SELECT level_of_education_code, year, budget_points, contract_points FROM passing_points");
    $stmt->execute();

    $pointsA = [
        'spo' => [],
        'bak' => [],
        'mag' => [],
    ];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $code = $row['level_of_education_code'];  
        $year = (int)$row['year'];
        $budget   = $row['budget_points'];
        $contract = $row['contract_points'];

        if (in_array($code, ['spo','bak','mag'], true)) {
            $pointsA[$code][$year] = [
                'budget_points'   => $budget,
                'contract_points' => $contract,
            ];
        }
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    exit("Ошибка работы с БД.");
}
?>
     
<div class="show_content_admission-item" data-categories-apl="admission-item">
            <div class="content_admission-conditions">
                <div class="admission_conditions-tittle">
                    <h1 class="admission_conditions-tittle-text">Условия приёма</h1>
                </div>
                <div class="admission_conditions-content">
                    <p class="admission_conditions-text">
                    Мы рады приветствовать абитуриентов, готовых присоединиться к нашему факультету!
                    Для поступления вы можете выбрать один из трёх простых путей:
                    </p>
                    <div class="admission_conditions-items">
                    <div class="admission_conditions-item">
                        <h2 class="admission_conditions-item-title">ЕГЭ</h2>
                        <p class="admission_conditions-item-text">
                        Успешно сдать Единый государственный экзамен по трём предметам:
                        </p>
                        <ul class="admission_conditions-list">
                        <li>Русский язык;</li>
                        <li>Математика (профильный уровень);</li>
                        <li>Физика или Информатика (на ваш выбор).</li>
                        </ul>
                    </div>
                    <div class="admission_conditions-item">
                        <h2 class="admission_conditions-item-title">После СПО</h2>
                        <p class="admission_conditions-item-text">
                        Если вы уже имеете диплом среднего профессионального образования,
                        достаточно сдать только внутренние вступительные экзамены нашего университета по
                        профильным дисциплинам.
                        </p>
                    </div>
                    <div class="admission_conditions-item">
                        <h2 class="admission_conditions-item-title">Плюсы</h2>
                        <p class="admission_conditions-item-text">После ЕГЭ</p>
                        <ul class="admission_conditions-list">
                            <li>Упрощенный процесс подачи документов в несколько вузов одновременно</li>
                            <li>Баллы ЕГЭ действительны 4 года</li>
                        </ul>
                        
                        <p class="admission_conditions-item-text">После СПО</p>
                        <ul class="admission_conditions-list">
                            <li>Ускоренное обучение по профильным направлениям</li>
                            <li>Практические навыки дают преимущество в обучении</li>
                            <li>Льготные условия для выпускников колледжей при поступлении</li>
                        </ul>
                    </div>
                    </div>
                    <p class="admission_conditions-text admission_conditions-conclusion">
                    По итогам оценки результатов мы формируем конкурсный рейтинг и приглашаем лучших
                    к обучению на нашем факультете. Желаем удачи и с нетерпением ждём вас в числе студентов!
                    </p>
                </div>
                <div class="content_admission-scores">
                    <div class="admission_scores-tittle">
                        <h1 class="admission_scores-tittle-text">Проходные баллы прошлых лет</h1>
                    </div>
                    <div class="admission_scores-content">
                        <p class="admission_scores-text">
                        Для вашего удобства мы собрали статистику проходных баллов за последние три года.
                        Эти данные помогут вам оценить свои шансы на поступление и лучше подготовиться к экзаменам.
                        </p>
                        
                        <div class="admission_scores-items">
                                <div class="admission_scores-item">
                                    
                                    <h2 class="admission_scores-item-title">Поступление на СПО</h2>
                                    <h2 class="admission_scores-item-title--text">(После 9-11 классов)</h2>
                                        <div class=""></div>
                                    <div class="admission_scores-table">
                                        <div class="admission_scores-row admission_scores-header">
                                            <div class="admission_scores-cell">Год</div>
                                            <div class="admission_scores-cell">Бюджет</div>
                                            <div class="admission_scores-cell">Контракт </div>
                                        </div>
                                        <?php foreach ($pointsA['spo'] as $code => $item):?>
                                            <div class="admission_scores-row">
                                                <div class="admission_scores-cell"><?=$code?></div>
                                                <div class="admission_scores-cell"><?=$item['budget_points']?></div>
                                                <div class="admission_scores-cell"><?=$item['contract_points']?></div>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    
                                    <p class="admission_scores-item-text">
                                    * Для абитуриентов со средним профессиональным образованием проходной балл определяется
                                    как средняя оценка его аттестата и результатов ОГЭ.
                                    </p>
                                </div>
                                <div class="admission_scores-item">
                                    <h2 class="admission_scores-item-title">Поступление на бакалавриат по ЕГЭ</h2>
                                    <h2 class="admission_scores-item-title--text">(После 11 класса)</h2>
                                    <div class="admission_scores-table">
                                    <div class="admission_scores-row admission_scores-header">
                                        <div class="admission_scores-cell">Год</div>
                                        <div class="admission_scores-cell">Бюджет</div>
                                        <div class="admission_scores-cell">Контракт</div>
                                    </div>
                                        <?php foreach ($pointsA['bak'] as $code => $item):?>
                                            <div class="admission_scores-row">
                                                <div class="admission_scores-cell"><?=$code?></div>
                                                <div class="admission_scores-cell"><?=$item['budget_points']?></div>
                                                <div class="admission_scores-cell"><?=$item['contract_points']?></div>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    
                                    <p class="admission_scores-item-text">
                                    * Баллы указаны суммарно за 3 экзамена: Русский язык, Математика (проф.) и Физика/Информатика.
                                    Для бюджетных мест учитывается конкурсный балл (сумма баллов ЕГЭ + индивидуальные достижения).
                                    </p>
                                </div>
                                <div class="admission_scores-item">
                                    <h2 class="admission_scores-item-title">Поступление по внутренним экзаменам</h2>
                                    <h2 class="admission_scores-item-title--text">(После СПО, бакалавриата, магистратуры)</h2>
                                    <div class="admission_scores-table">
                                        <div class="admission_scores-row admission_scores-header">
                                            <div class="admission_scores-cell">Год</div>
                                            <div class="admission_scores-cell">Бюджет</div>
                                            <div class="admission_scores-cell">Контракт</div>
                                        </div>
                                        <?php foreach ($pointsA['mag'] as $code => $item):?>
                                            <div class="admission_scores-row">
                                                <div class="admission_scores-cell"><?=$code?></div>
                                                <div class="admission_scores-cell"><?=$item['budget_points']?></div>
                                                <div class="admission_scores-cell"><?=$item['contract_points']?></div>
                                            </div>
                                        <?php endforeach;?>
                                    </div>  
                                    <p class="admission_scores-item-text">
                                    * Для абитуриентов, сдающих внутренние экзамены, проходной балл рассчитывается как
                                    средний процент правильных ответов за два теста: логика/алгоритмы и базовые ИТ-знания.
                                    </p>
                                </div>

                        </div>
                        
                        <p class="admission_scores-conclusion">
                        Обратите внимание, что проходные баллы могут меняться в зависимости от конкурса текущего года.
                        Для более точной информации следите за обновлениями на нашем официальном сайте.
                        </p>
                    </div>
                </div>
                <div class="calculation_form">
                    <div class="top_calculation_form-text">
                            <h1 class="calculation_form-title">Рассчитать шансы поступления исходя из прошлых годов</h1>
                    </div>
                     <div class="checkbox-container">
                        <div class="checkbox-item">
                            <input type="checkbox" id="check1" name="examType" class="exclusive-checkbox">
                            <label for="check1">ЕГЭ (баллы за предмет)</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="check2" name="examType" class="exclusive-checkbox">
                            <label for="check2">ОГЭ (оценка за предмет)</label>
                        </div>
                    </div>
                    <div class="top_calculation_form_input">   
                        <div class="calculation_group_about-item">
                            <input type="text" id="sub1" name="sub1" required placeholder="Математика">
                        </div>  
                        <div class="calculation_group_about-item">
                            <input type="text" id="sub2" name="sub2" required placeholder="Русский">
                        </div>
                        <div class="calculation_group_about-item">
                            <input type="text" id="sub3" name="sub3" required placeholder="Информатика / Физика">
                        </div>
                    </div>
                    <div class="calculation_tell_send">
                        <div class="calculation_tellus-text" hidden>
                            <div class="calculation_tellus_text-item" >
                                <textarea
                                    id="answ"
                                    name="answ"
                                    required
                                    value=""
                                ></textarea>
                            </div>
                        </div>
                        <div class="calculation-but">
                            <button class="calculation-button">Рассчитать</button>
                        </div>
                    </div>        
                </div>
                <div class="content_admission-exams">
                    <div class="admission_exams-tittle">
                        <h1 class="admission_exams-tittle-text">Информация о вступительных экзаменах</h1>
                    </div>
                    <div class="admission_exams-text">
                        Для абитуриентов, поступающих не по результатам ЕГЭ, мы проводим внутренние вступительные испытания.
                        Ниже представлена подробная информация о датах, времени и предметах экзаменов.
                    </div>
                    <div class="admission_exams-items">
                        <!-- Карточка для поступающих после СПО -->
                        <div class="admission_exams-item">
                            <h2 class="admission_exams-item-title">После СПО</h2>
                            
                            <p class="admission_exams-item-text">
                                Для абитуриентов со средним профессиональным образованием предусмотрены следующие экзамены:
                            </p>
                            
                            <ul class="admission_exams-list">
                                <li>
                                    <strong>Математика</strong>
                                   
                                    <p>Письменный экзамен по высшей математике. Продолжительность: 3 часа.</p>
                                </li>
                                <li>
                                    <strong>Информатика</strong>
                                    
                                    <p>Тестирование по основам программирования и информационным технологиям. Продолжительность: 2.5 часа.</p>
                                </li>
                            </ul>
                            
                            <p class="admission_exams-item-text">
                                <strong>Место проведения:</strong> Главный корпус, аудитория 310.<br>
                                <strong>При себе иметь:</strong> паспорт, документ об образовании, ручку.
                            </p>
                        </div>
                        <!-- Карточка для внутренних экзаменов -->
                        <div class="admission_exams-item">
                            <h2 class="admission_exams-item-title">Внутренние экзамены</h2>
                            
                            <p class="admission_exams-item-text">
                                Для абитуриентов, окончавших бакалавриат, предусмотрены следующие испытания:
                            </p>
                            
                            <ul class="admission_exams-list">
                                <li>
                                    <strong>Логика и алгоритмы</strong>
                                    
                                    <p>Тестирование способности к логическому мышлению и алгоритмизации. Продолжительность: 2 часа.</p>
                                </li>
                                <li>
                                    <strong>Базовые ИТ-знания</strong>
                                    
                                    <p>Проверка знаний основ информационных технологий и структур данных. Продолжительность: 2.5 часа.</p>
                                </li>
                            </ul>
                            
                            <p class="admission_exams-item-text">
                                <strong>Место проведения:</strong> Главный корпус, аудитория 215.<br>
                                <strong>При себе иметь:</strong> паспорт, документ об образовании, ручку.
                            </p>
                        </div>
                        <!-- Карточка с дополнительной информацией -->
                        <div class="admission_exams-item">
                            <h2 class="admission_exams-item-title">Важная информация</h2>
                            
                            <p class="admission_exams-item-text">
                                Для всех абитуриентов, сдающих внутренние экзамены:
                            </p>
                            
                            <ul class="admission_exams-list">
                                <li>
                                    <strong>Консультации:</strong>
                                  
                                    <p>Консультации проходят в аудитории 105. Рекомендуем посетить!</p>
                                </li>
                                <li>
                                    <strong>Регистрация:</strong>
                                    <p>Необходимо зарегистрироваться на экзамены не позднее, чем за 3 дня до даты проведения.</p>
                                </li>
                                <li>
                                    <strong>Результаты:</strong>
                                    <p>Результаты экзаменов будут опубликованы через 5 рабочих дней после сдачи.</p>
                                </li>
                            </ul>
                            
                            <p class="admission_exams-item-text">
                                <strong>Контактная информация:</strong><br>
                                Приёмная комиссия: +7 (495) 123-45-67<br>
                                Email: admissions@university.ru
                            </p>
                        </div>
                    </div>
                    <p class="admission_exams-conclusion">
                        Желаем успешной сдачи экзаменов! Рекомендуем заранее ознакомиться с программой вступительных испытаний
                        и посетить подготовительные консультации.
                    </p>
                </div>
            </div>
        </div>