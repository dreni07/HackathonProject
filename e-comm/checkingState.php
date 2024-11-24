<?php

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['product_id'])){
        $the_product_id = $_GET['product_id'];
        try{
            require '../authentication/sessions.inc.php';
            require '../authentication/db.inc.php';
            
            $the_user_id = $_SESSION['userId'];

            $the_value_returned = checking($the_user_id,$the_product_id,$pdo);
            $return_to_user = $the_value_returned ? ['success'=>'True'] : ['success'=>'False'];

            echo json_encode($return_to_user);
            
        }catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }
}


function checking($the_user_id,$the_product_id,$pdo){
    $the_user_id = $_SESSION['userId'];
    $the_sql_query = 'SELECT * FROM likedProducts WHERE product_liked_id = :product_liked_id AND user_liked_id = :user_liked_id;';
    $prepare = $pdo->prepare($the_sql_query);
    $prepare->bindParam(':product_liked_id',$the_product_id);
    $prepare->bindParam(':user_liked_id',$the_user_id);
    $prepare->execute();
    $fetching_all = $prepare->fetch(PDO::FETCH_ASSOC);

    return $fetching_all ? true:false;
}
 ?>