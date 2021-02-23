<?php

class Event {
    //Приватные свойства: ид события, дата события, имя события, доступность каждого типа билета (кроме обычного, он
    //доступен везде) и их цена.
    private $_event_id;
    private $_event_date;
    private $_event_name;
    private $_tickets_regular_price;
    private $_tickets_kid_available;
    private $_tickets_kid_price;
    private $_tickets_group_available;
    private $_tickets_group_price;
    private $_tickets_soft_available;
    private $_tickets_soft_price;

    //В конструкторе все эти свойства заполняются переданными данными
    public function __construct($event_id, $event_date, $event_name, $tickets_regular_price,
    $tickets_kid_available, $tickets_kid_price, $tickets_group_available, $tickets_group_price,
    $tickets_soft_available, $tickets_soft_price) {
        $this->_event_id = $event_id;
        $this->_event_date = $event_date;
        $this->_event_name = $event_name;
        $this->_tickets_regular_price = $tickets_regular_price;
        $this->_tickets_kid_available = $tickets_kid_available;
        $this->_tickets_kid_price = $tickets_kid_price;
        $this->_tickets_group_available = $tickets_group_available;
        $this->_tickets_group_price = $tickets_group_price;
        $this->_tickets_soft_available = $tickets_soft_available;
        $this->_tickets_soft_price = $tickets_soft_price;
    }

    //Вывод заголовка с названием события
    public function displayEventName() {
        return <<<EOT
        <h5>{$this->_event_name}</h5>
EOT;
    }

    //не выводится, добавляет инпут с id события форме
    public function displayEventId() {
        return <<<EOT
        <input type="hidden" name="event_id" value="{$this->_event_id}">
EOT;
    }

    //метод вывода блоков формы для обычных билетов, он выводится всегда. Подпись, инпут с количеством билетов,
    //скрытый инпут с ценой билета 
    public function displayRegularTicketsForm() {
        return <<<EOT
        <div>
        <label for="regular">Количество взрослых ({$this->_tickets_regular_price} руб.)</label><br>
        <input type="number" name="regular" class='regular'>
        <input type="hidden" name="regular_price" value="{$this->_tickets_regular_price}">
        </div>
EOT;
    }

    //этот метод проверяет, что полученный из базы данных тип билета доступен для покупки, после чего выводится
    //или нет, для детских, групповых и льготных билетов
    public function areTicketsAvailable($type, $price, $inputName, $inputPriceName, $string) {
        if($this->$type > 0) {
            return <<<EOT
            <div>
            <label for="{$inputName}">Количество $string ({$this->$price} руб.)</label><br>
            <input type="number" name="{$inputName}" class="{$inputName}">
            <input type="hidden" name="{$inputPriceName}" value="{$this->$price}">
            </div>
EOT;
        }
    }
}
?>