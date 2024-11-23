<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $the_product_name = $_GET['product_name'] ? $_GET['product_name'] : null;
    if($the_product_name){
        searchProducts($the_product_name);
    }
}

function searchProducts($product){
    try{    
        require '../authentication/db.inc.php';
        $sql_query = "SELECT * FROM products WHERE product_name LIKE '%$product%' AND product_in_stock > 0;";
        $preparing = $pdo->prepare($sql_query);
        $preparing->execute();

        $fetch_data = $preparing->fetchAll(PDO::FETCH_ASSOC);

        if($fetch_data){
            echo json_encode(['success'=>True,'data'=>$fetch_data]);
        }else{
            echo json_encode(['success'=>False]);
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}

?>