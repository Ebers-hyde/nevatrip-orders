<?php
require_once("../vendor/connect.php");

//класс для каждого заказа
class Order {

    //Свойства: ид пользователя, ид события, количество билетов, итоговая сумма заказа, дата создания 
    private $_user_id;
    private $_event_id;
    private $_tickets_amount;
    private $_sum;
    private $_created;

    // в конструкторе устанавливаются свойства кроме суммы и количества билетов
    public function __construct($user_id, $event_id) {
        $this->_user_id = $user_id;
        $this->_event_id = $event_id;
        //Дата создания перед записью переводится в московский часовой пояс
        date_default_timezone_set('Europe / Moscow');
        $this->_created = date("Y-m-d H:i:s");
    }

    //Метод записи суммы
    public function setOrderSum($sum) {
        $this->_sum = $sum;
    }

    //Метод записи количества билетов
    public function setOrderTickets($array) {
        $this->_tickets_amount = array_sum($array);
    }

    //Геттеры некоторых свойств: ид пользователя, ид события. Они будут нужны в сценарии создания заказа и билетов
    public function getUserId() {
        return $this->_user_id;
    }

    public function getEventId() {
        return $this->_event_id;
    }

    //Метод подготовки и записи заказа в БД. Данные всё те же, перечисленные раньше.
    public function saveOrder() {
        global $connect;
        $stmt = $connect->prepare("INSERT INTO `orders` 
        (`order_id`, `user_id`, `event_id`, `tickets_amount`, `sum`, `created`) 
        VALUES (:order_id, :user, :event_id, :tickets_amount, :summary, :order_time)");
        $stmt->execute([
        ':order_id' => NULL,
        ':user' => $this->_user_id,
        ':event_id' => $this->_event_id,
        ':tickets_amount' => $this->_tickets_amount,
        ':summary' => $this->_sum,
        ':order_time' => $this->_created,
        ]);
    }

}

?>