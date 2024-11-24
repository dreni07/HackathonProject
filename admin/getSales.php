<?php


if($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'){
    header('Location:./adminHome.php');
}


function currentMonth(){
    $date_object = new DateTime();
    $formated = $date_object->format('m');
    return $formated;
}



function gettingEachOrder(){
    $the_current_month = currentMonth();
    try{
        require '../authentication/db.inc.php';

        $the_sql = 'SELECT * FROM orders WHERE MONTH(order_date) = :the_current_month';// go on and take the month for each order_date;        
        $prepare = $pdo->prepare($the_sql);
        $prepare->bindValue(':the_current_month',$the_current_month);
        $prepare->execute();

        $fetched_data = $prepare->fetchAll(PDO::FETCH_ASSOC);

        $order_for_each_month = [];

        if($fetched_data){
            foreach($fetched_data as $order){
                $the_order_month = $order['order_date'];
                $spliting_order_date = explode('-',$the_order_month);
                $month = $spliting_order_date[2]; // the actual month

                if(key_exists($month,$order_for_each_month)){
                    $order_for_each_month[$month] += 1;
                }else{
                    $order_for_each_month[$month] = 1;
                }
            }
        }

        if($order_for_each_month){
            return $order_for_each_month;
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    return [];
}

$order_for_each_month = gettingEachOrder();


if($order_for_each_month){
    echo json_encode(['success'=>true,'data'=>$order_for_each_month]);
}else{
    echo json_encode(['success'=>false]);
}

?>