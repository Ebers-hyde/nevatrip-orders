<?php 
    session_start();
    require_once('connect.php');
    require_once('../classes/order.php');
    require_once('../classes/ticket.php');

    //функция, которая добавляет билеты в БД. Принимает количество билетов какого-то типа, тип билета в виде строки,
    //цену билета определённого типа, ид последнего заказа. Можно было его тоже объявить через global и не передавать. 
    function addTickets($tickets_amount, $string, $price, $last_order_id) {
        //предоставляется доступ к созданному объекту заказа
        global $order;
        //если были заказаны билеты какого-то типа
        if($tickets_amount > 0) {
            //для каждого из N заказанных билетов
            for($i=0; $i <= $tickets_amount-1; $i++) {
                //Создаётся новый объект билета
                $ticket = new Ticket($last_order_id, $string, $price);
                //Формируеся штрикод для него методом объекта
                $ticket->setBarcode($order->getEventId());
                //билет записывается в базу тоже методом объекта
                $ticket->saveTicket();
            };
        };
    }

    //все переданные из формы данные извлекаются в переменные: ид события, количество взрослых, 
    //детей, групповых билетов и льготников, цены на каждый билет
    extract($_POST);
    //ид пользователя
    $user_id = $_SESSION['user']['id'];

    //Создаётся новый объект заказа, куда передаются пришедшие в форме со страницы eventOrder данные
    $order = new Order($user_id, $event_id, $regular, $kids, $group, $soft);
    //Методом объекта вычисляется сумма
    $order->setOrderSum($regular_price, $kids_price, $group_price, $soft_price);
    //Другим методом заказ пишется в БД
    $order->saveOrder();
    
    //чтение последнего сделанного пользователем заказа. нужно для того, чтобы вытащить его ид и прицепить к билетам
    $check_order = $connect->query("SELECT * FROM `orders` WHERE `user_id` = {$order->getUserId()} ORDER BY `order_id` DESC LIMIT 1");
    if ($check_order->rowCount() > 0) {
        $last_order = $check_order->fetch(PDO::FETCH_ASSOC);
        $last_order_id = $last_order["order_id"];
    }

    //для записи билетов каждого типа каждый вызываем функцию addTickets.
    addTickets($regular, 'regular', $regular_price, $last_order_id);
    addTickets($kids, 'kid', $kids_price, $last_order_id);
    addTickets($group, 'group', $group, $last_order_id);
    addTickets($soft, 'soft', $soft_price, $last_order_id);
    
    //Снова редирект на страницу добавления заказов
    header('Location: ../eventOrder.php');
?>