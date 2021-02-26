<?php

class Event {
    //Приватные свойства: ид события, дата события, имя события, доступность каждого типа билета (кроме обычного, он
    //доступен везде) и их цена.
    private $_event_id;
    private $_event_date;
    private $_event_name;
    private $_tickets;

    //В конструкторе все эти свойства заполняются переданными данными
    public function __construct($event_id, $event_date, $event_name, $tickets) {
        $this->_event_id = $event_id;
        $this->_event_date = $event_date;
        $this->_event_name = $event_name;

        //Это массив строк из таблицы с типами билетов
        $this->_tickets = array();
        //Цикл для каждой строки, если ид события подходит, значит это нужный тип билета, он добавляется
        //к массиву tickets объекта
        foreach($tickets as $ticket) {
            if ($ticket['event_id'] == $this->_event_id) {
                $this->_tickets[] = $ticket;
            }
        }
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

    //Сколько разных билетов выделено под событие?
    public function getTicketsForms() {
        return count($this->_tickets);
    }
    //метод вывода блоков формы для билетов разных типов. Подпись с типом и ценой, инпут с количеством билетов,
    //скрытые инпуты с ценой билета и типом
    public function displayTicketsForm($ix) {
        return <<<EOT
        <div>
        <label for="amount">{$this->_tickets[$ix]['ticket_type']} ({$this->_tickets[$ix]['ticket_price']} руб.)</label><br>
        <input type="number" name="amount[{$ix}]" class='amount'>
        <input type="hidden" name="prices[{$ix}]" value={$this->_tickets[$ix]['ticket_price']}>
        <input type="hidden" name="tickets[{$ix}]" value={$this->_tickets[$ix]['ticket_type']}>
        </div>
EOT;
    }
}
?>