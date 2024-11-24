<?php
function checkIfExists($product_id,$category_id){
    try{
        require '../authentication/db.inc.php';
        $the_sql_statment = 'SELECT * FROM Products WHERE product_id > :product_id AND product_category = :product_category;';
        $preparing = $pdo->prepare($the_sql_statment);
        $preparing->bindParam(':product_id',$product_id);
        $preparing->bindParam(':product_category',$category_id);
        $preparing->execute();

        $fetched_products = $preparing->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetched_products){
        return $fetched_products;
    }

    return False;
}


function add_product_to($product_liked_id){
    try{
        require '../authentication/sessions.inc.php';
        require '../authentication/db.inc.php';
        $user_id = $_SESSION['userId'];
        $the_sql_query = 'INSERT INTO likedproducts (product_liked_id,user_liked_id) VALUES (:product_liked_id,:user_liked_id);';
        $preparing = $pdo->prepare($the_sql_query);
        $preparing->bindParam(':product_liked_id',$product_liked_id);
        $preparing->bindParam(':user_liked_id',$user_id);
        $preparing->execute();

        $the_row_count = $preparing->rowCount();

        $the_last_row_inserted = $pdo->lastInsertId();


        $get_product_liked = productLiked($the_last_row_inserted);

        $the_new_query = 'INSERT INTO interactions (product_interacted,user_interacted) VALUES (:product_interacted,:user_interacted);';
        $preparing = $pdo->prepare($the_new_query);
        $preparing->bindParam(':product_interacted',$get_product_liked);
        $preparing->bindParam(':user_interacted',$user_id);

        $preparing->execute();

    } catch(PDOException $e){
        die('Failed Inserting Because Of ' . $e->getMessage());
    }
    
    if($the_row_count){
        return ['success'=>'Added'];
    }else{
        return ['success'=>'Not Added'];
    }
}


// THIS IS A FUNCTION TO EXTRACT ALL THE PRODUCTS THAT THE USER HAS LIKED
// AND ALSO TO RETURN ALL THE SUGGESTED PRODUCTS THAT ARE ADDED AFTER THE PRODUCT THE USER LIKED WAS PUBLISHED
// OR ADDED IN THE DATABASE

function selectingAll(){
    try{
        require '../authentication/sessions.inc.php';
        require '../authentication/db.inc.php';
        $the_user_id = $_SESSION['userId'];
        $sql_statment = 'SELECT * FROM likedProducts 
        INNER JOIN products ON likedProducts.product_liked_id = products.product_id 
        INNER JOIN categories ON products.product_category = categories.category_id
        WHERE likedProducts.user_liked_id = :user_liked_id AND products.product_in_stock = 0;';
        $the_prepare = $pdo->prepare($sql_statment);
        $the_prepare->bindParam(':user_liked_id',$the_user_id);
        $the_prepare->execute();

        $fetched_data = $the_prepare->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of '.$e->getMessage());
    }

    if($fetched_data){
        $the_full_array = [];
        for($i = 0;$i<count($fetched_data);$i++){
            $the_product_id = $fetched_data[$i]['product_liked_id'];
            $the_category_id = $fetched_data[$i]['product_category'];
            $the_product_name = $fetched_data[$i]['product_name'];
            $the_full_array[$the_product_name] = [];
            $the_products = checkIfExists($the_product_id,$the_category_id);
            if($the_products){
                for($j = 0;$j<count($the_products);$j++){
                    array_push($the_full_array[$the_product_name],$the_products[$j]);
                }
            }
        }

        return $the_full_array;
    }

    return False;
}

function productLiked($the_id){
    try{
        require '../authentication/db.inc.php';

        $sql = 'SELECT product_liked_id FROM likedproducts WHERE likedProductId = :likedProductId;';
        $the_preparment = $pdo->prepare($sql);
        $the_preparment->bindParam(':likedProductId',$the_id);
        $the_preparment->execute();

        $fetched = $the_preparment->fetch(PDO::FETCH_ASSOC)['product_liked_id'];

        if($fetched){
            return $fetched;
        }

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $product_liked_id = $_POST['product_id'];
    add_product_to($product_liked_id);
}





?>