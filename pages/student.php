<?php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['root'] != 'stud' && $_SESSION['root'] != 'prepod')) {
    header('Location: /');
    exit;
}?>
   <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
    ?>
    <main class="main">
        <div class="content_upload">
            <div class="group">
                <p class="upload_lebel" typ="upload_lebel">Группа</p>
                <input type="text" class="education" id="education" error="Дисциплина" name="education" required placeholder="Напишите название группы">
            </div>
           <div class="course">
                <p class="upload_lebel" typ="upload_lebel">Курс</p>
                <select name="course" required id="course">
                    <option value="" disabled selected hidden>Выберите курс...</option>
                </select>
            </div>
            <?php
                include $_SERVER['DOCUMENT_ROOT'] . '/components/downloadComponents/selectComp.php';
            ?>
            <div class="dis cipline">
                <p class="upload_lebel" typ="upload_lebel">Тип занятия</p>
                <select name="discipline" required id="discipline">
                    <option value="" disabled selected hidden>Выберите тип занятия...</option>
                    <option value="Лекция">Лекция</option>
                    <option value="Практика">Практика</option>
                </select>
            </div>
            <div class="upload_items-search">
                <div class="upload_item-but-search">
                    <button class="upload_item-but-but-search">Найти</button>
                </div>
            </div>
        </div>
<div class="main_download_materials" hidden>
    <div class="get_subjects_material">
    </div>
    <div class="excel_group_download">
       <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/components/downloadComponents/excellStDown.php';
        ?>
    </div>
</div>
    </main>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
    ?>
<div id="toast" class="toast hidden"></div>
<script src="/assets/js/download-script.js"></script>