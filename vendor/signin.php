<?php
    require_once('../classes/loggedUser.php');

    //Принимаем форму с логином и паролем
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    //создаём класс пытающегося войти пользователя, дальше см. Класс loggedUser
    $loggedUser = new LoggedUser($login, $password);
    header('Location: ../eventOrder.php');
?>

