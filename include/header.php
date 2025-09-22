<?php 

 session_start();
  
 ?> 
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>ФКНиТ</title>
    <link rel="stylesheet" href="/assets/css/main.css?v=3">
    <script src="/assets/js/main.js"></script>
</head>
<body>
    <header class="header">
        <div class="header_nav">
            <a href="/" class="header_logo">
                <img src="/assets/def_img/logo.png" alt="Логотип факультета" class="logo__image">
            </a>
            <div class="header_menu">
                <div class="header_menu-item">
                    <a href="/" class="header_link">Главная</a>
                </div>
                <div class="header_menu-item">
                    <a href="/applicants" class="header_link">Абитуриентам</a>
                </div>
                <div class="header_menu-item">
                    <a href="/faculty-news" class="header_link">О факультете</a>
                </div>
                <div class="header_menu-item">
                    <a href="/teachers" class="header_link">Преподаватели</a>
                </div>
                <div class="header_menu-item">
                    <a href="/contact" class="header_link">Контакты</a>
                </div>
            </div>
            <div class="header_auth-item dropdown">
                <?php if(isset($_SESSION['logged_in']) || $_SESSION['logged_in']): ?>
                    <a href="#" class="header_login-link dropdown-toggle" id="loginDropdown"><?= $_SESSION['name'] ?></a>
                    <div class="dropdown-menu" aria-labelledby="loginDropdown">
                        <?php if($_SESSION['root'] == 'prepod'): ?>
                            <a class="dropdown-item" href="/apload">Загрузить материал</a>
                        <?php endif; ?>
                        <?php if($_SESSION['root'] == 'prepod' || $_SESSION['root'] == 'stud'): ?>
                            <a class="dropdown-item" href="/download">Скачать материал</a>
                        <?php endif; ?>
                            <a class="dropdown-item" href="logic\logout.php">Выйти</a>
                    </div>
                <?php else: ?>
                    <a href="/login" class="header_login-link">Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </header> 