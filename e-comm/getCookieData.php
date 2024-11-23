<?php

function currentDate(){
    $the_date = new DateTime();
    $formated = $the_date->format('Y-m-d');
    return $formated;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $product_clicked_id = $_POST['product_clicked_id'];
    try{
        require '../authentication/sessions.inc.php';
        require '../authentication/db.inc.php';

        $user_id = $_SESSION['userId'];
        $into_string = (string)currentDate();

        $the_sql = 'INSERT INTO userdata (user_id,product_clicked_id,the_date) VALUES (:user_id,:product_clicked,:the_date);';
        $preparing = $pdo->prepare($the_sql);

        $preparing->bindParam(':user_id',$user_id);
        $preparing->bindParam(':product_clicked',$product_clicked_id);
        $preparing->bindParam(':the_date',$into_string);

        $preparing->execute();

        $the_row_count = $preparing->rowCount();

        if($the_row_count){
            echo json_encode(['success'=>true]);
        }else{
            echo json_encode(['success'=>false]);
        }
    } catch(PDOException $e){
        die('Failed Because Of '  . $e->getMessage());
    }
} 


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        require '../authentication/db.inc.php';
        require '../authentication/sessions.inc.php';
        $the_user_id = $_SESSION['userId'];

        $the_sql = 'SELECT * FROM userdata WHERE user_id = :user_id;';
        $the_preparment = $pdo->prepare($the_sql);
        $the_preparment->bindParam(':user_id',$the_user_id);
        $the_preparment->execute();

        $fetched = $the_preparment->fetchAll(PDO::FETCH_ASSOC);

        if($fetched){
            echo json_encode(['success'=>true,'data'=>$fetched]);
        }else{
            echo json_encode(['success'=>false]);
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}

?>