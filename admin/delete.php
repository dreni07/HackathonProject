<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $the_delete_id = $_GET['delete_id'];
    deleteProduct($the_delete_id);
}


function deleteProduct($the_id){
    try{
        require '../authentication/db.inc.php';

        $the_sql = 'DELETE FROM products WHERE product_id = :product_id;';
        $the_preparment = $pdo->prepare($the_sql);
        $the_preparment->bindParam(':product_id',$the_id);
        $the_preparment->execute();

        if($the_preparment->rowCount()){
            header('Location:productsByAI.php');
        }
    } catch(PDOException){
        die('Failed Because Of ' . $e->getMessage());
    }
}
?>