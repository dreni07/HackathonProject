<?php

class interactingWithDb{
    public function firstOrderByAI(){
        try{
            require '../authentication/db.inc.php';

            $added_by_ai = 'yes';

            $sql_query = 'SELECT order_id FROM orders
            INNER JOIN products ON orders.id_product = products.product_id
            WHERE added_by_ai = :added_by_ai ORDER BY orders.order_id ASC LIMIT 1;';


            $preparing = $pdo->prepare($sql_query);

            $preparing->bindParam(':added_by_ai',$added_by_ai);

            $preparing->execute();

            $fetched = $preparing->fetch(PDO::FETCH_ASSOC);

            if($fetched){
                return $fetched['order_id'];
            }
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }

        return;
    }

    public function numberOfOrdersBefore(){ 

        $the_order_id = $this->firstOrderByAI() ? $this->firstOrderByAI() : null;

        if($the_order_id){
            try{    
                require '../authentication/db.inc.php';
    
                $the_sql_query = 'SELECT COUNT(*) AS orders_before FROM orders WHERE order_id < :order_id;';

                $the_preparment = $pdo->prepare($the_sql_query);
                $the_preparment->bindParam(':order_id',$the_order_id);

                $the_preparment->execute();

                $fetched_data = $the_preparment->fetch(PDO::FETCH_ASSOC);

                if($fetched_data){
                    return $fetched_data['orders_before'];
                }
            } catch(PDOException $e){
                die('Failed Because Of ' . $e->getMessage());
            }
        }else{

            return;
        }
        
    }

    public function numberOfOrdersAfter(){

        $the_order_id = $this->firstOrderByAI() ? $this->firstOrderByAI() : null;

        if($the_order_id){
            try{    
                require '../authentication/db.inc.php';
    
                $the_sql_query = 'SELECT COUNT(*) AS orders_after FROM orders WHERE order_id > :order_id;';
    
                $the_prep = $pdo->prepare($the_sql_query);
                $the_prep->bindParam(':order_id',$the_order_id);
    
                $the_prep->execute();

                $fetched_data = $the_prep->fetch(PDO::FETCH_ASSOC);

                if($fetched_data){
                    return $fetched_data['orders_after'];
                }
            } catch(PDOException $e){
                die('Failed Because Of ' . $e->getMessage());
            }


            return;
        }
       
    }

    public function sendData(){
        if($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_GET['dataset']) && empty($_GET['new_order'])){
            $the_orders_before = $this->numberOfOrdersBefore();
            $the_orders_after = $this->numberOfOrdersAfter();

            if($the_orders_before && $the_orders_after){
                echo json_encode(['success'=>true,'numberOfOrdersBefore'=>$the_orders_before,'numberOfOrdersAfter'=>$the_orders_after]);
            }else{
                echo json_encode(['success'=>false]);
            }
        }
    }

    public function getForEachDay(){
        $the_current_id = $this->firstOrderByAI();
        try{
            require '../authentication/db.inc.php';

            $sql_query = 'SELECT * FROM orders WHERE order_id >= :current_id;';
            
            $the_preparment = $pdo->prepare($sql_query);
            $the_preparment->bindParam(':current_id',$the_current_id);


            $the_preparment->execute();

            $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);

            
            if($fetched_data){
                return $fetched_data;
            }
        } catch(PDOException $e){
            die('Failed ' . $e->getMessage());
        }

        return;
    }

    public function returningDataSet(){
       $the_data = $this->getForEachDay();
       $dataset = []; 
       foreach($the_data as $data){
            $the_order_date = $data['order_date'];

            if(key_exists($the_order_date,$dataset)){
                $dataset[$the_order_date] += 1;
            }else{
                $dataset[$the_order_date] = 1;
            }

       }

       return $dataset;
    }

   
}

$db_instance = new interactingWithDb();

$db_instance->sendData();

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['dataset'])){
    $the_data_set = $db_instance->returningDataSet();
    $json_data = [];

    foreach($the_data_set as $key=>$value){
        $csv_data_completed = [];
        $csv_data_completed['date'] = $key;
        $csv_data_completed['orders'] = $value;

        $json_data[] = $csv_data_completed;
    }

    echo json_encode(['success'=>true,'data'=>$json_data]);
}


// take the first order that was a product generated from AI -- completed
// then take the number of orders that were generated before that 
// and the number of orders after that
// then go on and compare those two




?>