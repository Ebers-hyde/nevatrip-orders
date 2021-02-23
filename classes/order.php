<?php
require_once("../vendor/connect.php");

//класс для каждого заказа
class Order {

    //Свойства: ид пользователя, ид события, количество билетов каждого типа, итоговая сумма заказа, дата создания 
    private $_user_id;
    private $_event_id;
    private $_regular_amount;
    private $_kids_amount;
    private $_group_amount;
    private $_soft_amount;
    private $_sum;
    private $_created;

    // в конструкторе устанавливаются свойства кроме суммы
    public function __construct($user_id, $event_id, $regular_amount, $kids_amount, $group_amount, $soft_amount) {
        $this->_user_id = $user_id;
        $this->_event_id = $event_id;
        $this->_regular_amount = $regular_amount;
        $this->_kids_amount = $kids_amount;
        $this->_group_amount = $group_amount;
        $this->_soft_amount = $soft_amount;
        //Дата создания перед записью переводится в московский часовой пояс
        date_default_timezone_set('Europe / Moscow');
        $this->_created = date("Y-m-d H:i:s");
    }

    //Метод вычисления суммы, исходя из количества билетов и цены каждого из них
    public function setOrderSum($regular_price, $kids_price, $group_price, $soft_price) {
        $this->_sum = ($this->_regular_amount * $regular_price) + ($this->_kids_amount * $kids_price) +
        ($this->_group_amount * $group_price) + ($this->_soft_amount * $soft_price);
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
        (`order_id`, `user_id`, `event_id`, `tickets_regular_amount`, `tickets_kids_amount`, `tickets_group_amount`, 
        `tickets_soft_amount`, `sum`, `created`) 
        VALUES (:order_id, :user, :event_id, :regular, :kids, :group, :soft, :summary, :order_time)");
        $stmt->execute([
        ':order_id' => NULL,
        ':user' => $this->_user_id,
        ':event_id' => $this->_event_id,
        ':regular' => $this->_regular_amount,
        ':kids' => $this->_kids_amount,
        ':group' => $this->_group_amount,
        ':soft' => $this->_soft_amount,
        ':summary' => $this->_sum,
        ':order_time' => $this->_created,
        ]);
    }

}

?>