<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])){


        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $product_price = $_POST['product_price'];


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