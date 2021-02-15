<?php 
    session_start();
    require_once('connect.php');

    extract($_POST);

    if($password_confirm === $password) {

        $password = md5($password);

        $stmt = $connect->prepare("INSERT INTO `users` 
        (`user_id`, `login`, `password`, `full_name`) 
        VALUES (:user_id, :login, :password, :full_name)");

        $stmt->execute([
            ':user_id' => NULL,
            ':login' => $login,
            ':password' => $password,
            ':full_name' => $full_name,
        ]);

        $check_user = $connect->query("SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
            if ($check_user->rowCount() > 0) {

            $user = $check_user->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user'] = [
            "id" => $user['user_id'],
            "login" => $user['login'],
            ];

            header('Location: ../eventOrder.php');

            }

    } else {
        $_SESSION['message'] = 'Пароли не совпадают!';
        header('Location: ../register.php');
    }
?>