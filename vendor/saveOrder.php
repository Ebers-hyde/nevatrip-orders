<?php 
    session_start();
    require_once('connect.php');

    //все переданные из формы данные извлекаются в переменные: ид события, количество взрослых, 
    //детей, групповых билетов и льготников, цены на каждый билет
    extract($_POST);
    //на всякий случай, ид пользователя
    $user = $_SESSION['user']['id'];
    //сумма взрослых билетов по формуле: их количество * на стоиомость
    $regularTicketsSum = $regular * $regular_price;
    //сумма детских билетов
    $kidTicketsSum = $kids * $kids_price;
    //сумма групповых билетов
    $groupTicketsSum = $group * $group_price;
    //сумма льготных билетов
    $softTicketsSum = $soft * $soft_price;

    //полная стоимость билетов в заказе
    $summary = $regularTicketsSum + $kidTicketsSum + $groupTicketsSum + $softTicketsSum;

    //датавремя создания заказа, текущая
    $order_time = date("Y-m-d H:i:s");

    //подготовка и вставка значений в таблицу заказа: ид заказа, ид пользователя, ид события, количество взрослых,
    //количество детей, групповых и льготных билетов (может быть 0 - это значит что просто не заказывают, а может
    //быть NULL - на событие вообще не продаются такие билеты и инпут скрыт)
    $stmt = $connect->prepare("INSERT INTO `orders` 
    (`order_id`, `user_id`, `event_id`, `tickets_regular_amount`, `tickets_kids_amount`, `tickets_group_amount`, 
    `tickets_soft_amount`, `sum`, `created`) 
    VALUES (:order_id, :user, :event_id, :regular, :kids, :group, :soft, :summary, :order_time)");
    $stmt->execute([
        ':order_id' => NULL,
        ':user' => $user,
        ':event_id' => $event_id,
        ':regular' => $regular,
        ':kids' => $kids,
        ':group' => $group,
        ':soft' => $soft,
        ':summary' => $summary,
        ':order_time' => $order_time,
    ]);
    //чтение последнего сделанного пользователем заказа. нужно для того, чтобы вытащить его ид и прицепить к билетам
    $check_order = $connect->query("SELECT * FROM `orders` WHERE `user_id` = $user ORDER BY `order_id` DESC LIMIT 1");
    if ($check_order->rowCount() > 0) {

        $last_order = $check_order->fetch(PDO::FETCH_ASSOC);
        $last_order_id = $last_order["order_id"];
    }

    //снова вырвиглаза, циклы записи билетов, в зависимости от заказанного количества разных типов.
    //предположим, обычные взрослые билеты можно заказать на любое событие, поэтому тут без проверки.
    for($i=0; $i <= $regular-1; $i++) {
        //создаётся рандомная часть штрихкода
        $bcRandom = rand(1111, 9999);
        //а сам штрихкод вида 013-1234 - сначала ид события, затем эта рандомная часть через тире.
        //Нельзя так делать, знаю. Это не гарантия, что для каждого билета штрихкод будет уникален.
        $barcode = $event_id . "-" . $bcRandom;
        //запись билета: ид билета, ид события, ид заказа, тип билета, цена, штрихкод.
        //нет ид пользователя, события и даты заказа, я думаю, что их можно прочитать из заказа в отдельной таблице, поэтому не добавил сюда.
        $stmt_tickets = $connect->prepare("INSERT INTO `tickets` (`ticket_id`, `order_id`, `ticket_type`, `price`, `barcode`) VALUES (:ticket_id, :order_id, :ticket_type, :price, :barcode)");
        $stmt_tickets->execute([
            ':ticket_id' => NULL,
            ':order_id' => $last_order_id,
            ':ticket_type' => 'regular',
            ':price' => $regular_price,
            ':barcode' => $barcode,
        ]);
    };
    
    //а дальше с проверкой по каждому типу.
    if($kids > 0) {
        for($i=0; $i <= $kids-1; $i++) {
            $bcRandom = rand(1111, 9999);
            $barcode = $event_id . "-" . $bcRandom;
            $stmt_tickets = $connect->prepare("INSERT INTO `tickets` (`ticket_id`, `order_id`, `ticket_type`, `price`, `barcode`) VALUES (:ticket_id, :order_id, :ticket_type, :price, :barcode)");
            $stmt_tickets->execute([
                ':ticket_id' => NULL,
                ':order_id' => $last_order_id,
                ':ticket_type' => 'kid',
                ':price' => $kids_price,
                ':barcode' => $barcode,
            ]);
        };
    };

    if($group > 0) {
        for($i=0; $i <= $group-1; $i++) {
            $bcRandom = rand(1111, 9999);
            $barcode = $event_id . "-" . $bcRandom;
            $stmt_tickets = $connect->prepare("INSERT INTO `tickets` (`ticket_id`, `order_id`, `ticket_type`, `price`, `barcode`) VALUES (:ticket_id, :order_id, :ticket_type, :price, :barcode)");
            $stmt_tickets->execute([
                ':ticket_id' => NULL,
                ':order_id' => $last_order_id,
                ':ticket_type' => 'group',
                ':price' => $group_price,
                ':barcode' => $barcode,
            ]);
        };
    };

    if($soft > 0) {
        for($i=0; $i <= $soft-1; $i++) {
            $bcRandom = rand(1111, 9999);
            $barcode = $event_id . "-" . $bcRandom;
            $stmt_tickets = $connect->prepare("INSERT INTO `tickets` (`ticket_id`, `order_id`, `ticket_type`, `price`, `barcode`) VALUES (:ticket_id, :order_id, :ticket_type, :price, :barcode)");
            $stmt_tickets->execute([
                ':ticket_id' => NULL,
                ':order_id' => $last_order_id,
                ':ticket_type' => 'soft',
                ':price' => $soft_price,
                ':barcode' => $barcode,
            ]);
        };
    };

    header('Location: ../eventOrder.php');
?>
