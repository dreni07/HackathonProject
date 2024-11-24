<?php

function checkTempTable(){
    try{
        require '../authentication/db.inc.php';
        $sql_query = 'SELECT COUNT(*) FROM temp_table;';
        $preparing = $pdo->prepare($sql_query);
        $preparing->execute();
        $fetched = $preparing->fetchColumn();

    } catch (PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetched){
        return true;
    }else{
        return false;
    }

}

function addToTempTable($last_row){
    try{
        require '../authentication/db.inc.php';
        $sql_query = 'INSERT INTO temp_table (last_product) VALUES (:last_product);';
        $preparing = $pdo->prepare($sql_query);
        $preparing->bindParam(':last_product',$last_row);
        $preparing->execute();


        $row_count = $preparing->rowCount();
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    return $row_count ? true:false;

}

function get_the_last_row(){
    try{
        require '../authentication/db.inc.php';
        $the_last_row_id = 'SELECT product_id FROM products ORDER BY product_id DESC LIMIT 1;';
        $preparing = $pdo->prepare($the_last_row_id);
        $preparing->execute();

        $fetched = $preparing->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    $last_row = $fetched['product_id'];

    $the_temp_table = checkTempTable();

    if(!($the_temp_table)){
        addToTempTable($last_row);
    }

    return $last_row;
}

function checkingIfSame(){
    $the_last_row = get_the_last_row();// take the last row of the base table
    try{
        require '../authentication/db.inc.php';
        $the_sql_query = 'SELECT last_product FROM temp_table;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();

        $fetched = $the_preparment->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    $the_temp_table_id = $fetched['last_product'];// select the only id saved in temp_table

        // nese nuk jane te njejta atehere return false prej funksionit
        // edhe gjithashtu bone reset
        // the temp_table ku kome fshi domethan 
        // qat row-in n temp_table edhe kome shti the last_row

    if(!($the_last_row == $the_temp_table_id)){
        deletingFromTable();
        addToTempTable($the_last_row);
        $the_data = extractingTheProduct($the_last_row);
        $product_category_id = $the_data['product_category']; // funksion per mi marr te dhenat per produktin
        // tash mduhet edhe ni funksion qe bon check se a osht
        // useri perkates per qat produkt
        $the_value_returned = isTheCurrentUser($product_category_id); // nese qiky funksion
        // kthen true value
        // atehere kthej domethane
        // te dhenat prej funksionit extractingTheProduct
        // dhe dergo notification te useri perkates
        if($the_value_returned){
            $api_array = [
                'success'=>true,
                'product_name'=>$the_data['product_name'],
                'product_price'=>$the_data['product_price'],
            ];

            return $api_array;
        }
    }

    $the_api_failed = [
        'success'=>false
    ];
    
    return $the_api_failed;
}

function deletingFromTable(){
    try{    
        require '../authentication/db.inc.php';
        $the_sql_query = 'DELETE FROM temp_table;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();

        $the_rows_affected = $the_preparment->rowCount();

    } catch(PDOException $e){
        die('Failed Because Of ' .$e->getMessage());
    }


    return $the_rows_affected ? true:false;
}



// use this function to extract the data about the new product
// that was added in our database
// and to see to which user to sent the notification
// by checking if the user has liked products and also if one of those products was recently added to the database
function extractingTheProduct($product_id){
    try{
        require '../authentication/db.inc.php';
        $sql_query = 'SELECT * FROM products WHERE product_id = :product_id;';
        $the_preparment = $pdo->prepare($sql_query);
        $the_preparment->bindParam(':product_id',$product_id);
        $the_preparment->execute();

        $fetch_data = $the_preparment->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetch_data){
        return $fetch_data;
    }else{
        return false;
    }

}

function isTheCurrentUser($product_category){
    try{
        require '../authentication/sessions.inc.php';
        require '../authentication/db.inc.php';
        $user_liked_id = $_SESSION['userId'];
        $sql_query = 'SELECT * FROM likedproducts INNER JOIN products ON likedproducts.product_liked_id = products.product_id WHERE user_liked_id = :user_liked_id AND products.product_category = :last_product_category;';
        $the_prepare = $pdo->prepare($sql_query);
        $the_prepare->bindParam(':user_liked_id',$user_liked_id);
        $the_prepare->bindParam(':last_product_category',$product_category);

        $the_prepare->execute();

        $fetched = $the_prepare->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetched){
        // domethane nese qaj produkti fundit qe u bo add
        // nese ni user i caktum
        // e ka ni product ne liked products te ti qe osht me kategori te njejte si produkti
        // i fundit qe u bo add atehere return true
        return true;
    }else{
        return false;
    }
        
    
}

function sendingNotification(){
    $the_function_checked = checkingIfSame();
    if($the_function_checked['success'] == true){
        echo json_encode(['success'=>$the_function_checked]);
    }else{
        echo json_encode(['success'=>false]);
    }

}



sendingNotification();


?>