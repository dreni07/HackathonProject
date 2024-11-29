<?php

class CheckOrders{
    public function getFromTempTable(){
        try{
            require '../authentication/db.inc.php';

            $the_sql_query = 'SELECT * FROM temp_order_table;';

            $the_preparment = $pdo->prepare($the_sql_query);

            $the_preparment->execute();

            $fetched_data = $the_preparment->fetch(PDO::FETCH_ASSOC);

            if($fetched_data){
                return $fetched_data['last_order_id'];
            }
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }

        return;
    }

    public function getTheLastOrder(){
        $temporary_table = $this->getFromTempTable();
        try{
            require '../authentication/db.inc.php';

            $the_sql_query = 'SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1;';
            $the_preparment = $pdo->prepare($the_sql_query);
            $the_preparment->execute();

            $fetched = $the_preparment->fetch(PDO::FETCH_ASSOC);

            $fetched_id = $fetched['order_id'];
            if(!($temporary_table)){ // if there is no rows in the temporary table push it
                $this->insertIntoTempTable($fetched_id);
            }


            return $fetched_id;
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }

    public function insertIntoTempTable($the_last_id){
        try{    
            require '../authentication/db.inc.php';

            $the_sql_query = 'INSERT INTO temp_order_table (last_order_id) VALUES (:last_order_id);';

            $the_preparment = $pdo->prepare($the_sql_query);
            $the_preparment->bindParam(':last_order_id',$the_last_id);

            $the_preparment->execute();

        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }

    

    public function checkIfIsNewOrder(){
        // create a table that will hold the current oldest order
        $the_temp_table = $this->getFromTempTable();
        $the_orders_table = $this->getTheLastOrder();

        if($the_temp_table !== $the_orders_table){

            $this->deleteFromTempTable();
            $this->insertIntoTempTable($the_orders_table);

            echo json_encode(['success'=>true]);
            return;
        }else{
            echo json_encode(['success'=>false]);
        }
    }

    public function deleteFromTempTable(){
        try{
            require '../authentication/db.inc.php';

            $sql_query = 'DELETE FROM temp_order_table;';
            $the_preparment = $pdo->prepare($sql_query);
            $the_preparment->execute();
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }
}

$new_order_instance = new CheckOrders();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $new_order_instance->checkIfIsNewOrder();
}

?>