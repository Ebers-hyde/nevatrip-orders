<?php
    session_start();
    if($_SESSION['user']) {
        header('Location: eventOrder.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/indexSignupStyles.css">
</head>
<body>
    <form class="loginForm" action="vendor/signin.php" method="post">
    <label>Логин</label>
    <input type="text" name="login" placeholder="Введите логин" id="">
    <label>Пароль</label>
    <input type="password" placeholder="Введите пароль" name="password" id="">
    <button type="submit">Войти</button>
    <p>У вас нет аккаунта? <a href="register.php">- зарегистрируйтесь</a></p>
    <?php 
        if($_SESSION['message']) {
            echo '<p class="msg"> ' . $_SESSION['message'] . '</p>';
        }
        unset($_SESSION['message']);
    ?>
    </form>
</body>
</html>