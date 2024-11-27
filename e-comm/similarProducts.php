<?php
if(isset($_GET['product_id'])){
    $the_similar_product_id = $_GET['product_id'];
    $the_values = extractingAll($the_similar_product_id) ? extractingAll($the_similar_product_id) : 'No Products Similar';
    // print_r($the_values);
    print_r(json_encode(['success'=>true,'data'=>$the_values]));

    
}else{
    print_r(json_encode(['success'=>false]));
    header('Location:./home.php');
}

function gettingSimilarProducts($the_product_id){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM products WHERE product_id = :product_id;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->bindParam(':product_id',$the_product_id);
        $the_preparment->execute();

        $fetched_products = $the_preparment->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetched_products){
        return $fetched_products;
    }else{
        return false;
    }
}

function extractingAll($the_product_id){
    try{
        require '../authentication/db.inc.php';

        $product_in_stock = 0;

        $the_data_about_product = gettingSimilarProducts($the_product_id);
        $product_category = $the_data_about_product['product_category'];

        

        $the_sql_query = 'SELECT * FROM products WHERE product_category = :product_category AND product_id != :product_id AND product_in_stock > :product_in_stock';
        $the_preparment = $pdo->prepare($the_sql_query);

        $the_preparment->bindParam(':product_category',$product_category);
        $the_preparment->bindParam(':product_id',$the_product_id);
        $the_preparment->bindValue(':product_in_stock',$product_in_stock);

        $the_preparment->execute();

        $fetching = $the_preparment->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetching){
        return $fetching;
    }else{
        return false;
    }
}


?>
