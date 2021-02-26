<?php
    session_start();
    require_once("vendor/connect.php");
    require_once("classes/event.php");

    //если не залогинен, редирект на индекс, вход
    if(!$_SESSION['user']) {
        header('Location: index.php');
    }
    // достаём из таблицы заказы для того, чтоб показать форму заказов под каждое событие, события записываются в массив
    $result = $connect->query('SELECT * FROM events');
    $events = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $events[] = $row;
    }
    $resultTickets = $connect->query('SELECT * FROM tickets');
    $tickets = array();
    while($row = $resultTickets->fetch(PDO::FETCH_ASSOC)) {
        $tickets[] = $row;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление заказов и билетов</title>
    <link rel="stylesheet" href="assets\css\orderStyles.css">
</head>
<body>
    <h3>Добавление заказов и билетов</h3>
    <!-- Цикл, вывод формы для создания заказа и билетов на каждое событие-->
    <?php foreach($events as $event):?>
    <!-- Cоздаются объекты для каждого события, с передачей параметров из элементов массива -->
    <?php 
    $new_event = new Event($event['event_id'], $event['event_date'], $event['event_name'], $tickets);
    // вывод названия события через метод
    echo $new_event->displayEventName();?>
    <form action="vendor/saveOrder.php" method="post" class="orderForm">
    <?php
    //через методы добавляются ид события для передачи (скрыт)
    echo $new_event->displayEventId();

    //Возвращается количество разных типов билетов, выделенных под событие
    $ix= $new_event->getTicketsForms();
    //Запускается цикл. Например можно заказывать на событие 4 разных билетов
    for($i=0; $i <= $ix-1; $i++) {
        //Методом объекта выводится блок формы, инпут для количества билетов с подписью, скрытые инпуты. 
        echo $new_event->displayTicketsForm($i);
    }
    ?>
    <input class="formSubmit" type="submit" value="Заказать">  
    </form>
    <?php endforeach;?>
    <a href="listOrders.php">Посмотреть добавленные заказы и билеты</a>
</body>
</html>