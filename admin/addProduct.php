<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])){

        $count = 1;

        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $product_price = $_POST['product_price'];
        $product_in_stock = $_POST['product_in_stock'];

        $the_base_file = 'product_image/';
        $the_image_name = $_FILES['image']['name'];
        $the_file_extension = pathinfo(basename($the_image_name),PATHINFO_EXTENSION);
        $the_base_name = pathinfo(basename($the_image_name),PATHINFO_BASENAME);
        $full_file = $the_base_file . $the_base_name . '.' . $the_file_extension;

        if(!is_dir($the_base_file)){
            mkdir($the_base_file,0777,true);
        }

        while(file_exists($full_file)){
            $full_file = $the_base_file . $the_base_name . '_' . $count . '.' . $the_file_extension;
            $count++;
        }

        if(move_uploaded_file($_FILES['image']['tmp_name'],$full_file)){
            try{
                require '../authentication/db.inc.php';

                $sql_query = 'INSERT INTO products (product_category,product_name,product_image,product_price,product_in_stock) VALUES (:product_category,:product_name,:product_image,:product_price,:product_in_stock);';
                $preparing = $pdo->prepare($sql_query);

                $preparing->bindParam(':product_category',$product_category);
                $preparing->bindParam(':product_name',$product_name);
                $preparing->bindParam(':product_price',$product_price);
                $preparing->bindParam(':product_in_stock',$product_in_stock);
                $preparing->bindParam(':product_image',$the_image_name);

                $preparing->execute();

                $the_row_count = $preparing->rowCount();

                if($the_row_count){
                    echo json_encode(['success'=>true]);
                }else{
                    echo json_encode(['success'=>false]);
                }

            } catch(PDOException $e){
                die('Failed Becuase Of ' . $e->getMessage());
            }
        }
    }else{
        echo json_encode(['success'=>'bad']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method='post' enctype='multipart/form-data'>
        <input type="file" name='image'>
        <input type="submit">
    </form>
</body>
</html>