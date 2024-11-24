<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $product_name = $_POST['product_name'];
        $product_price = (int)$_POST['product_price'];
        $product_in_stock = $_POST['product_in_stock'];

        $product_description = $_POST['product_description'];
        $product_image = $_POST['product_image'];
        $product_category = $_POST['product_category'];

        $added_by_ai = $_POST['added_by_ai'];


        try{
            require '../authentication/db.inc.php';

            $the_sql_query = 'INSERT INTO products(product_category,product_description,product_image,product_in_stock,product_name,product_price,added_by_ai) 
            VALUES (:product_category,:product_description,:product_image,:product_in_stock,:product_name,:product_price,:added_by_ai);';

            $preparing = $pdo->prepare($the_sql_query);

            $preparing->bindParam(':product_category',$product_category);
            $preparing->bindParam(':product_description',$product_description);
            $preparing->bindParam(':product_image',$product_image);
            $preparing->bindParam(':product_in_stock',$product_in_stock);
            $preparing->bindParam(':product_name',$product_name);
            $preparing->bindParam(':product_price',$product_price);
            $preparing->bindParam(':added_by_ai',$added_by_ai);

            $preparing->execute();
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }

        // $the_image = $_POST['product_image'];
        // if($the_image){
        //     echo json_encode(['success'=>'Got DATA','image'=>$the_image]);
        // }else{
        //     echo json_encode(['success'=>'Failed']);
        // }
    }

?>