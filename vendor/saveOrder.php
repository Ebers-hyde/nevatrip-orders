<?php 
    session_start();
    require_once('connect.php');
    require_once('../classes/order.php');
    require_once('../classes/ticket.php');

    //Функция вычисления суммы заказа. Оперирует с массивами количества билетов каждого типа (amount) и цены на
    // каждый тип билета 

    function getTicketsSum() {
        global $amount;
        global $prices;
        
        //Создаётся новый массив
        $array = array();
        //Запускается цикл, для каждого элемента массива цен его значение умножается на количество приобретённых
        //билетов. Получается массив со стоимостями всех билетов определённого типа
        for($i=0; $i<=count($prices)-1; $i++) {
            $array[] = $prices[$i] * $amount[$i];
        }
        //Возвращается вся сумма 
        return array_sum($array);
    }

    //функция, которая добавляет билеты в БД. Принимает массив с типами билетов. Оперирует так же массивами с количеством
    //билетов каждого типа, ид последнего заказа и объектом заказа 
    function addTickets($types) {
        //предоставляется доступ к созданному объекту заказа

        global $amount;
        
        global $order;

        global $last_order_id;

        //создан инкремент, чтобы записывать сначала первое значение из массива типов билета в заказ.
        $j = 0;
        //Цикл для каждого элемента массива с количеством. То есть например сначала надо создать 2 Взрослых билета,
        //потом 3 детских и т.д.
        foreach($amount as $am) {
            //ещё один внутренний инкремент
            $i = 1;
            //вложенный цикл. инкремент i возрастает каждый раз после создания нового билета, пока не достигнет значения am. 
            //Таким образом и будет записано 2 взрослых билета. цикл остановится, инкрементируется уже j и цикл начнётся 
            //заново уже для другого типа билетов. Не просто понять, но додуматься было намного сложнее. 
            while ($i <= $am) {
                //Создаётся новый объект билета
                $new_ticket = new Ticket($last_order_id, $types[$j]);
                //Формируеся штрикод для него методом объекта
                $new_ticket->setBarcode($order->getEventId());
                //билет записывается в базу тоже методом объекта
                $new_ticket->saveTicket();
                $i++;
            }
            $j++;
        }
    }

    //все переданные из формы данные извлекаются в переменные: ид события, массив с количеством приобретённых билетов
    //каждого типа, массив с ценой для каждого типа билета, массив с типами нужных билетов.
    extract($_POST);

    //ид пользователя
    $user_id = $_SESSION['user']['id'];

    //Создаётся новый объект заказа, куда передаются пришедшие в форме со страницы eventOrder данные
    $order = new Order($user_id, $event_id);
    //Функцией вычисляется сумма заказа и записывается в переменную
    $sumOfArray = getTicketsSum();
    //Устанавливается методом объекта
    $order->setOrderSum($sumOfArray);
    //Так же методом объекта устанавливается количество билетов
    $order->setOrderTickets($amount);
    //Другим методом заказ пишется в БД
    $order->saveOrder();
    
    //чтение последнего сделанного пользователем заказа. нужно для того, чтобы вытащить его ид и прицепить к билетам
    $check_order = $connect->query("SELECT * FROM `orders` WHERE `user_id` = {$order->getUserId()} ORDER BY `order_id` DESC LIMIT 1");
    if ($check_order->rowCount() > 0) {
        $last_order = $check_order->fetch(PDO::FETCH_ASSOC);
        $last_order_id = $last_order["order_id"];
    }

    //Запуск функции создания билетов.
    addTickets($tickets);
    
    
    //Снова редирект на страницу добавления заказов
    header('Location: ../eventOrder.php');
?>