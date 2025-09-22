<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
?>

<main class="login_form">
    <div class="main_login-text">
        <form method="POST" action="/logic/login.php">
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" id="username" name="username" required placeholder="Введите ваш логин">
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required placeholder="Введите ваш пароль">
            </div>
            <button type="submit" class="submit-btn">Войти</button> 
            <div class="call_back_text">Забыли пароль?</div>
        </form>
    </div>
    <div class="hiddent_alert_login" hidden>
        <span class="alert-icon">🔑</span>
        <div class="alert-title">Восстановление пароля</div>
        <div class="alert-content">
            Если вы забыли пароль, обратитесь в УИТ. Независимо от того, преподаватель вы или студент.<br><br>
            <strong>УИТ находится:</strong><br>
            7 корпус, 2 этаж, кабинет 215<br><br>
            <strong>Рабочие часы:</strong><br>
            Пн-Пт: 9:00-18:00<br>
            Сб: 10:00-15:00
        </div>
        <button class="alert-close">Понятно</button>
    </div>
    <div class="alert-backdrop" hidden></div>      
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
?>
<div id="toast" class="toast hidden"></div>