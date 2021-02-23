<?php 
    require_once('connect.php');
    require_once('../classes/loggedUser.php');
    
    //извлекаем данные из формы со страницы регистрации: фио, логин, пароль и подтверждение
    extract($_POST);

    //если пароль и подтверждение совпадают, подготавливаем и отправляем запрос на запись пользователя в БД
    //Пока без всякой проверки, но это только здесь. Можно было тоже сделать через класс
    if($password_confirm === $password) {

        //пароль хэшируется и не отправляется в чистом виде
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

        //после регистрации сразу происходит стандартная процедура входа через создание объекта класса LoggedUser
        $loggedUser = new LoggedUser($login, $password);

        //редирект на страницу создания заказа
        header('Location: ../eventOrder.php');
    }
?>