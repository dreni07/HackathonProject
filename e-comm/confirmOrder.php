<?php
require '../authentication/sessions.inc.php';

function changingOrderStatus($the_order_id){
    try{
        require '../authentication/db.inc.php';
        $null_value = null;
        $order_status = 'ACCEPTED';
        $the_sql_statment = 'UPDATE orders SET order_completion = :order_completion WHERE order_id = :order_id;';
        $the_preparment = $pdo->prepare($the_sql_statment);
        $the_preparment->bindParam(':order_completion',$order_status);
        $the_preparment->bindParam(':order_id',$the_order_id);

        $the_preparment->execute();

        $the_row_count = $the_preparment->rowCount();

    } catch(PDOException $e){
        die('Failed Because Of '.$e->getMessage());
    }


    if($the_row_count){
        return True;
    }
    return False;
}

function confirmOrder(){
    $fetched = null;
    try{
        $message_wrong = False;
        require '../authentication/db.inc.php';
        // require '../authentication/sessions.inc.php';

        $the_order_completion = 'PENDING';
        $the_user_id = $_SESSION['userId'];


        $the_sql_statment = 'SELECT orders.order_quantity,orders.order_id,products.product_in_stock,products.product_id FROM orders
        INNER JOIN products ON orders.id_product = products.product_id
        WHERE id_user = :id_user 
        AND order_completion = :order_completion;';

        $the_sql_prepare = $pdo->prepare($the_sql_statment);
        $the_sql_prepare->bindParam(':order_completion',$the_order_completion);
        $the_sql_prepare->bindParam(':id_user',$the_user_id);
        $the_sql_prepare->execute();

        $fetched = $the_sql_prepare->fetchAll(PDO::FETCH_ASSOC);

        for($j = 0;$j<count($fetched);$j++){
            $the_value = changingOrderStatus($fetched[$j]['order_id']);
            $the_order_quantity = $fetched[$j]['order_quantity'];
            $the_product_id = $fetched[$j]['product_id'];
            $update_quantity = updateOrderQuantity($the_order_quantity,$the_product_id);

            if(!$the_value){
                $message_wrong = True;
            }


        }


    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($message_wrong){
        return False;
    }else{
        $deleting_card = deleteCurrentCart($the_user_id);
        return $fetched;
    }
}

function updateOrderQuantity($the_order_quantity,$the_product_id){
    try{
        require '../authentication/db.inc.php';
        $the_old_product_in_stock = oldProductInStock($the_product_id);
        $the_new_value = $the_old_product_in_stock - $the_order_quantity;
        if($the_new_value < 0){
            $the_new_value = 0;
        }

        // NOW UPDATE THE ORDER QUANTITY
        $sql_ = 'UPDATE Products SET product_in_stock = :product_in_stock WHERE product_id = :product_id;';
        $prepare = $pdo->prepare($sql_);
        $prepare->bindParam(':product_in_stock',$the_new_value);
        $prepare->bindParam(':product_id',$the_product_id);
        $prepare->execute();

        // check if updated worked or not

        $the_row_count = $prepare->rowCount();
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($the_row_count){
        return True;
    }

    return False;

}

function oldProductInStock($product_id){
    try{
        require '../authentication/db.inc.php';
        $sql_query = 'SELECT product_in_stock FROM Products WHERE product_id = :product_id;';
        $the_preparment = $pdo->prepare($sql_query);
        $the_preparment->bindParam(':product_id',$product_id);
        $the_preparment->execute();

        $fetched_data = $the_preparment->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage()); 
    }

    if($fetched_data){
        return $fetched_data['product_in_stock'];
    }

    return False;
}

function deleteCurrentCart($the_user_id){
    try{
        require '../authentication/db.inc.php';
        $the_sql_query = 'DELETE cart FROM cart INNER JOIN orders ON cart.id_order = orders.order_id WHERE orders.id_user = :user_id;';
        $preparment = $pdo->prepare($the_sql_query);
        $preparment->bindParam(':user_id',$the_user_id);
        $preparment->execute();
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $the_val = confirmOrder();
    if($the_val){
        $the_product_interacted = $the_val;

        foreach($the_product_interacted as $product_ordered){
            $the_product_id = $product_ordered['product_id'];
            $the_user_id = $_SESSION['userId'];

            addToInteractions($the_product_id,$the_user_id);
        }

        echo json_encode(['success'=>True]);
    }else{
        echo json_encode(['success'=>False]);
    }
}

function addToInteractions($the_product_interacted,$the_user_id){
    try{

        require '../authentication/db.inc.php';

        $the_sql_query = 'INSERT INTO interactions (product_interacted,user_interacted) VALUES (:product_interacted,:user_interacted);';
        $the_preparment = $pdo->prepare($the_sql_query);

        $the_preparment->bindParam(':product_interacted',$the_product_interacted);
        $the_preparment->bindParam(':user_interacted',$the_user_id);

        $the_preparment->execute();

        $the_row_count = $the_preparment->rowCount();

        if($the_row_count){
            echo json_encode(['success'=>true,'added_to_inter'=>true]);
        }

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}

?>

