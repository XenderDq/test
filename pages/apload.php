<?php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || $_SESSION['root'] != 'prepod') {
    header('Location: /');
    exit;
}
?>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
?>
    <main class="main">
        <div class="content_upload">
            <?php
                include $_SERVER['DOCUMENT_ROOT'] . '/components/aploadComponents/lvlEducComp.php';
            ?>
            <div class="second_upload_select">
                <div class="dis_cipline">
                    <p class="upload_lebel" typ="upload_lebel">Дисциплина</p>
                    <input type="text" class="discipline_class" id="discipline_class" error="Дисциплина" name="discipline_class" required placeholder="Напишите название дисциплины">
                </div>
                <div class="typeofdisc">
                    <p class="upload_lebel" typ="upload_lebel" hidden>Тип занятия</p>
                    <select name="typeofdisc"  id="typeofdisc"> 
                        <option value="" disabled selected hidden>Выберите тип занятия...</option>
                        <option value="Лекция">Лекция</option>
                        <option value="Практика">Практика</option>
                    </select>
                </div>
            </div>
            <div class="name_of_material">
                <p class="upload_lebel" typ="upload_lebel">Название материала</p>
                <input type="text" class="material" id="material" error="Название материала" name="material" required placeholder="Напишите название материала">
            </div>

            <div class="upload_file_block">
                <p class="upload_lebel" typ="upload_lebel">Загрузите файл материала</p>
                <div class="drop_area" id="drop_area">
                    <p>Перетащите файл сюда или <span id="file_select">выберите файл</span></p>
                    <input type="file" id="file_input" hidden accept=".pdf,.doc,.docx,.txt,.xls,.xlsx,.ppt,.pptx" />
                </div>
                <p class="file_name" id="file_name">Файл не выбран</p>
            </div>
            <div class="upload_items">
                <div class="upload_item-img">
                    <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect width="96" height="96" fill="url(#pattern0_186_494)"/>
                    <defs>
                        <pattern id="pattern0_186_494" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_186_494" transform="scale(0.00444444)"/>
                        </pattern>
                        <image id="image0_186_494" width="225" height="225" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                </div>
                <div class="upload_item-but">
                    <button class="upload_item-but-but" id="upload_btn">Загрузить</button>
                </div>
            </div>
        </div>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/components/aploadComponents/searchComponent.php';
        ?>
    </main>
    <div id="toast" class="hidden"></div>
    <div id="toast_excell" class="hidden"></div>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
    ?>