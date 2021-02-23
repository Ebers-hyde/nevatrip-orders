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
    <!-- Громоздкая строка, создаются объекты для каждого события, с передачей параметров из элементов массива -->
    <?php $new_event = new Event($event['event_id'], $event['event_date'], $event['event_name'], $event["tickets_regular_price"],
    $event["tickets_kid_available"], $event["tickets_kid_price"], $event["tickets_group_available"], $event["tickets_group_price"],
    $event["tickets_soft_available"], $event["tickets_soft_price"]);
    // вывод названия события через метод
    echo $new_event->displayEventName();?>
    <form action="vendor/saveOrder.php" method="post" class="orderForm">
    <?php
    //через методы добавляются ид события для передачи (скрыт), и инпуты формы в зависимости от того, доступны ли билеты
    //определённого типа
    echo $new_event->displayEventId();
    echo $new_event->displayRegularTicketsForm();
    echo $new_event->areTicketsAvailable('_tickets_kid_available', '_tickets_kid_price', 'kids', 'kids_price', 'детей');
    echo $new_event->areTicketsAvailable('_tickets_group_available', '_tickets_group_price', 'group', 'group_price', 'групповых билетов');
    echo $new_event->areTicketsAvailable('_tickets_soft_available', '_tickets_soft_price', 'soft', 'soft_price', 'льготных билетов');
    ?>
    <input class="formSubmit" type="submit" value="Заказать">  
    </form>
    <?php endforeach;?>
    <a href="listOrders.php">Посмотреть добавленные заказы и билеты</a>
</body>
</html>