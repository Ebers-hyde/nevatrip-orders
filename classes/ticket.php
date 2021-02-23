<?php
require_once("../vendor/connect.php");

//Класс для билетов
class Ticket {
    //Свойства: ид заказа, тип, цена и штрихкод
    private $_order_id;
    private $_type;
    private $_price;
    private $_barcode;

    //всё кроме штрихкода записывается в конструкторе
    public function __construct($order_id, $type, $price) {
        $this->_order_id = $order_id;
        $this->_type = $type;
        $this->_price = $price;
    }

    //в метод приходит ид события, генерируется случайное 4-значное число, затем формируется штрихкод путём их соединения  
    public function setBarcode($event_id) {
        $bcRandom = rand(1111, 9999);
        $this->_barcode = $event_id . '-' . $bcRandom;
    }

    //Метод записи билета в БД. добавлен только ид каждого билета, который устанавливается автоматически в базе
    public function saveTicket() {
        global $connect;
        $stmt = $connect->prepare("INSERT INTO `tickets` (`ticket_id`, `order_id`, `ticket_type`, `price`, `barcode`) 
        VALUES (:ticket_id, :order_id, :ticket_type, :price, :barcode)");
        $stmt->execute([
            ':ticket_id' => NULL,
            ':order_id' => $this->_order_id,
            ':ticket_type' => $this->_type,
            ':price' => $this->_price,
            ':barcode' => $this->_barcode
        ]);
    }
}
?>