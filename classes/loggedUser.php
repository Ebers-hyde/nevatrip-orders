<?php 
session_start();
require_once("../vendor/connect.php");

class LoggedUser 
{
    //checkUser - свойство с методом запроса к базе данных. наверное, так неправильно, но пока так.  
    private $id;
    private $login;
    private $checkUser;

    //в конструкторе объявляется и осуществляется запрос к БД, в зависимости от этого записываются другие свойства
    //объекта
    public function __construct($lg, $pw) {
        global $connect;
        $this->checkUser = $connect->query("SELECT * FROM `users` WHERE `login` = '$lg' AND `password` = '$pw'");

        if ($this->checkUser->rowCount() > 0) {

            $user = $this->checkUser->fetch(PDO::FETCH_ASSOC);

            $this->id = $user['user_id'];
            $this->login = $user['login'];
            //ну и если они есть, запускается следующий метод, инициализирующий сессию с данными пользователя
            if($this->id && $this->login) {
                $this->setLoggedUser();
            }
        }

    }
    
    public function setLoggedUser() {
        $_SESSION['user'] = [
            "id" => $this->id,
            "login" => $this->login,
        ];
    }
}
?>