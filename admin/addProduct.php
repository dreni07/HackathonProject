<?php
    function addingProduct(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])){
            $get_the_base = 'product_images/';
            $get_the_name = $_FILES['image']['name'];
            $get_the_extension = pathinfo(basename($get_the_name),PATHINFO_EXTENSION);
            $base_name = pathinfo(basename($get_the_name),PATHINFO_BASENAME);

            echo $get_the_extension;
            echo $base_name;
        }else{
            echo 'No way';
        }
    }
    addingProduct();

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