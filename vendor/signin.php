<?php

    session_start();
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $check_user = $connect->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    if ($check_user->rowCount() > 0) {

        $user = $check_user->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user'] = [
            "id" => $user['user_id'],
            "full_name" => $user['full_name'],
        ];

        header('Location: ../eventOrder.php');

    } else {
        $_SESSION['message'] = 'Введен неверный логин или пароль';
        header('Location: ../index.php');
    }
    ?>

