<?php
    session_start();
    require_once("vendor/connect.php");

    //если не залогинен, редирект на индекс, вход
    if(!$_SESSION['user']) {
        header('Location: index.php');
    }
    // достаём из таблицы заказы для того, чтоб показать форму заказов под каждое событие
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
    <h5><?=$event['event_name'];?></h5>
    <form action="vendor/saveOrder.php" method="post" class="orderForm">
    <input type="hidden" name="event_id" value="<?=$event['event_id'];?>">
    <div>
    <label for="regular">Количество взрослых (<?=$event["tickets_regular_price"]?> руб.)</label><br>
    <input type="number" name="regular" class="regular">
    <input type="hidden" name="regular_price" value="<?=$event["tickets_regular_price"]?>">
    </div>
    <!--Проверка, допустимо ли добавлять детские билеты на событие. Если да, показываем input.
        Да, так писать ужасно, тем более типов билетов может быть не 4, а 40. 
        но на то я и джун, потом обязательно найду решение --> 
    <?php if($event["tickets_kid_available"] > 0):?>
            <div>
            <label for="kids">Количество детей (<?=$event["tickets_kid_price"]?> руб.)</label><br>
            <input type="number" name="kids" class="kids">
            <input type="hidden" name="kids_price" value="<?=$event["tickets_kid_price"]?>">
            </div>
        <?php endif;?>
        <!--Проверка, допустимо ли добавлять групповые билеты на событие. Если да, показываем input -->
        <?php if($event["tickets_group_available"] > 0):?>
            <div>
            <label for="kids">Количество групповых билетов (<?=$event["tickets_group_price"]?> руб.)</label><br>
            <input type="number" name="group" class="group">
            <input type="hidden" name="group_price" value="<?=$event["tickets_group_price"]?>">
            </div>
        <?php endif;?>
        <!--Проверка, допустимо ли добавлять льготные билеты на событие. Если да, показываем input -->
        <?php if($event["tickets_soft_available"] > 0):?>
            <div>
            <label for="kids">Количество льготных билетов (<?=$event["tickets_soft_price"]?> руб.)</label><br>
            <input type="number" name="soft" class="soft">
            <input type="hidden" name="soft_price" value="<?=$event["tickets_soft_price"]?>">
            </div>
        <?php endif;?>
    <input class="formSubmit" type="submit" value="Заказать">  
    </form>
    <?php endforeach;?>
    <a href="listOrders.php">Посмотреть добавленные заказы и билеты</a>
</body>
</html>