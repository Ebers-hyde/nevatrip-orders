<?php
    session_start();
    require_once("vendor/connect.php");

    //если не залогинен, редирект на индекс, вход
    if(!$_SESSION['user']) {
        header('Location: index.php');
    }
    // достаём из БД заказы для того, чтоб показать таблицу заказов под каждое событие
    $resultOrders = $connect->query('SELECT * FROM orders');
    $orders = array();
    while($row = $resultOrders->fetch(PDO::FETCH_ASSOC)) {
        $orders[] = $row;
    }

    // достаём из БД билеты для того, чтоб показать таблицу билетов
    $resultTickets = $connect->query('SELECT * FROM bought_tickets');
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
    <title>Заказы и билеты</title>
    <link rel="stylesheet" href="assets\css\orderStyles.css">
</head>
<body>
    <h3>Заказы</h3>
    <!-- Для каждого заказа вывод строк с данными-->
    <table>
        <tr>
            <td>Ид заказа</td>
            <td>Ид пользователя</td>
            <td>Ид события</td>
            <td>Количество билетов</td>
            <td>Сумма </td>
            <td>Заказ создан:</td>
        </tr>
    <?php foreach($orders as $order):?>
        <tr>
            <td><?=$order["order_id"]?></td>
            <td><?=$order["user_id"]?></td>
            <td><?=$order["event_id"]?></td>
            <td><?=$order["tickets_amount"]?></td>
            <td><?=$order["sum"]?> рублей</td>
            <td><?=$order["created"]?></td>
        </tr>
    <?php endforeach;?>
    </table>
    <h3>Билеты</h3>
    <!-- Для каждого билета вывод строк с данными-->
    <table>
        <tr>
            <td>Ид билета</td>
            <td>Ид заказа</td>
            <td>Тип билета</td>
            <td>Штрихкод</td>
        </tr>
    <?php foreach($tickets as $ticket):?>
        <tr>
            <td><?=$ticket["ticket_id"]?></td>
            <td><?=$ticket["order_id"]?></td>
            <td><?=$ticket["ticket_type"]?></td>
            <td><?=$ticket["barcode"]?></td>
        </tr>
    <?php endforeach;?>
    </table>
    <a href="eventOrder.php">Вернуться на страницу создания заказов</a>
</body>
</html>