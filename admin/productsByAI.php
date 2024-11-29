<?php

function getProductsByAI(){
    try{    
        require '../authentication/db.inc.php';

        $added_by_ai = 'yes';

        $the_sql = 'SELECT * FROM products WHERE added_by_ai = :added_by_ai;';

        $the_preparment = $pdo->prepare($the_sql);
        $the_preparment->bindParam(':added_by_ai',$added_by_ai);
        $the_preparment->execute();

        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetched_data){
        return $fetched_data;
    }
}

$AIProducts = getProductsByAI() ? getProductsByAI() : [];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim|Roboto Slab|Athiti|Cabin Condensed|Lora|Montserrat|Merriweather|Brusher|Pacifico">
    <style>
        body{
            margin:0;
            padding:0;
            display:flex;

        }

        .title-products-AI{
            width:100%;
            text-align:center;
        }

        .container-introduction{
            width:100%;
        }

        .title-products-AI h2{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;

        }
        .products-AI-container{
            width:100%;
            height:100%;
            display:flex;
            justify-content:center;
        }
        .all-products{
            width:80%;
            height:80%;
            display:flex;
            flex-direction:column;
            align-items:center;
            overflow:auto;
        }
        .all-products .product{
            margin:15px 0;
            flex-shrink:1;
            flex-grow:1;
            width:100%;
            height:100px;
            background:#FFFFF0;
            border-radius:16px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2), 0 4px 18px rgba(0, 0, 0, 0.19);
            display:flex;
            align-items:center;
        }
        .product .full-container-data{
            width:100%;
            display:flex;
            justify-content:space-between;
        }

        .image-content img{
            padding-left:5px;
            border-radius:6px;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2), 0 4px 1px rgba(0, 0, 0, 0.19);

        }
        .image-content{
            display:flex;
        }
        .image-content p{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            padding-left:20px;
            padding-top:5px;
            font-size:20px;
        }

        .button{
            padding-top:20px;
            padding-right:20px;
        }
        .button button{
            padding:10px 20px;
            border:none;
            background-color:rgb(245, 198, 206);
            color:#333;
            cursor:pointer;
            font-family:'Athiti';
            font-weight:1000;
            border-radius:4px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2), 0 4px 18px rgba(0, 0, 0, 0.19);
            transition:.3s ease-in-out;
        }

        .button button:hover{
            box-shadow: 0 8px 8px rgba(0, 0, 0, 0.2), 0 4px 18px rgba(0, 0, 0, 0.19);

        }
        
    </style>
</head>
<body>
    <?php require 'navbar.php'?>

    <div class="container-introduction">
        <div class="title-products-AI">
            <h2>You Can See Products Added By AI</h2>
            <div class="products-AI-container">
                <div class="all-products">
                    <?php foreach($AIProducts as $product): ?>

                        <div class="product">
                            <div class="full-container-data">
                                <div class="image-content">
                                    <img src="<?php echo $product['product_image'] ?>" height='80' width='120'>
                                    <p><?php echo $product['product_name'] ?></p>
                                </div>
                                <div class="button">
                                    <button><a href="delete.php?delete_id=<?php echo $product['product_id']?>" style='text-decoration:none;color:#333;'>Delete</a></button>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>