<?php

class orderDetails{
    public function getProductDetails(){
        try{
            require '../authentication/db.inc.php';

            $the_sql_query = 'SELECT * FROM products;';
            $the_preparment = $pdo->prepare($the_sql_query);
            $the_preparment->execute();


            $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);

            $full_data = [];

            foreach($fetched_data as $data){
                $the_object = [];

                $the_product_id = $data['product_id'];
                $the_product_name = $data['product_name'];
                $the_product_description = $data['product_description'];

                $the_object['product_name'] = $the_product_name;
                $the_object['product_id'] = $the_product_id;
                $the_object['product_description'] = $the_product_description;



                $full_data[] = $the_object;
            }


            echo json_encode(['data'=>$full_data]);
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }
}


$the_instance = new orderDetails();


$the_instance->getProductDetails();


?>