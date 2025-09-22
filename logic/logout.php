<?php
session_start();

// Очищаем все данные сессии
unset($_SESSION['logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['name']);
unset($_SESSION['root']);

// Уничтожаем сессию
session_destroy();

// Перенаправляем на главную страницу
header('Location: /');
exit;?>