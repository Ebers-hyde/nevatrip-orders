<?php
    session_start();

    //если в сессии уже установлен пользователь, происходит редирект на страницу создания заказа
    if($_SESSION['user']) {
        header('Location: eventOrder.php');
    }
?>

<!-- Иначе форма входа со ссылкой на страницу регистрации-->

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
    </form>
</body>
</html>