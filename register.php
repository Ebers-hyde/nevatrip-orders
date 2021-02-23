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
    <form class="registerForm" action="vendor/signup.php" method="post" enctype="multipart/form-data">
    <label>Логин</label>
    <input type="text" name="login" placeholder="Введите свой логин" id="">
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введите свой пароль" id="">
    <label>Подтверждение пароля</label>
    <input type="password" name="password_confirm" placeholder="Подтвердите свой пароль" id="">
    <label>ФИО</label>
    <input type="text" name="full_name" placeholder="Введите свое полное имя" id="">
    <button type="submit">Создать аккаунт</button>
    <p>У вас уже есть аккаунт? <a href="index.php"> - авторизуйтесь</a></p>
    </form>
</body>
</html>