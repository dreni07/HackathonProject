<?php
require '../authentication/sessions.inc.php';
function seeCart(){
    try{
        require '../authentication/db.inc.php';
        $the_order_completion = 'Pending';
        $the_user_id = $_SESSION['userId'];
        $the_sql = 'SELECT * FROM cart INNER JOIN orders ON cart.id_order = orders.order_id INNER JOIN Products ON orders.id_product = Products.product_id WHERE orders.id_user = :id_user AND orders.order_completion = :the_order_completion;';
        $the_prepare = $pdo->prepare($the_sql);
        $the_prepare->bindParam(":id_user",$the_user_id);
        $the_prepare->bindParam(":the_order_completion",$the_order_completion);
        $the_prepare->execute();

        $fetched = $the_prepare->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e){
        die('Failed Getting Data Because Of '.$e->getMessage());
    }


    if($fetched){
        return $fetched;
    }else{
        return [];
    }
}



function displayingAll(){
    $the_current_cart = seeCart(); 
    $the_dict_data = [];
    for($i = 0;$i<count($the_current_cart);$i++){
        $the_order_quantity = $the_current_cart[$i]['order_quantity'];
        $the_product_id = $the_current_cart[$i]['product_id'];
        if(array_key_exists($the_product_id,$the_dict_data)){
            $the_dict_data[$the_product_id] += $the_order_quantity;
        }else{
            $the_dict_data[$the_product_id] = $the_order_quantity;
        }
    }

    return $the_dict_data;
}

function finalCart(){
    $the_products = seeCart();
    $number_of_products = displayingAll();
    $full_products = [];
    $temp_array = [];
    for($j = 0;$j<count($the_products);$j++){
        $the_current_product_id = $the_products[$j]['product_id'];
        if(!in_array($the_current_product_id,$temp_array)){
            $the_number_of_products = $number_of_products[$the_current_product_id];
            $full_products[$the_number_of_products] = $the_products[$j];
            array_push($temp_array);
        }
    }

    return $full_products;
}

function total_and_names(){
    $the_full_data = finalCart();
    $the_total = [];
    $the_full_total = 0;
    if($the_full_data){
        foreach($the_full_data as $number=>$data){
            $product_name = $data['product_name'];
            $product_price = $data['product_price'];
            $the_total_for_product = $number * $data['product_price'];
            array_push($the_total,$the_total_for_product);
        }
    
        for($j = 0;$j<count($the_total);$j++){
            $the_full_total += $the_total[$j];
        }

        return [
            'the_full_data'=>$the_full_data,
            'the_total'=>$the_full_total
        ];
    }

    return [];
}

$the_total_data = total_and_names() ? total_and_names()['the_full_data'] : null;
$the_total_price = total_and_names() ? total_and_names()['the_total'] : null;







// masi ekom marr qita
// tash shko edhe merri te dhenat
// per produktet paraprake




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='cart.css'>
    <link rel='stylesheet' href='../css/logIn.css?v=1.0'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim|Roboto Slab|Athiti|Cabin Condensed|Lora|Montserrat|Merriweather|Brusher|Pacifico">
</head>
<body>
<div class="container-cart">
        <div class="cart-info">
            <div class="left-side-cart">
                <div class="title-part">
                    <h1>Your Cart</h1>
                </div>
                <div class="products-part">
                    <div class="products-div">
                        <?php if($the_total_data):?>
                            <?php foreach($the_total_data as $data):?>
                                <div class="product">
                                    <div class="image-product">
                                        <img src="../admin/product_image/<?php echo $data['product_image'] ?>" height='100' width='150'>
                                    </div>
                                    <div class="product-details">
                                        <p>Product Name:<?php echo htmlspecialchars($data['product_name'])?></p>
                                        <p>Product Quantity:<?php echo htmlspecialchars($data['order_quantity'])?></p>
                                        <p>Total For Product:<b><?php echo $data['order_quantity'] * $data['product_price'] ?>&euro;</b></p>
                                    </div>

                                    
                                </div>
                                
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style='position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);color:#333;font-family:"Anaheim";font-weight:1000;'>No Products Added</p>
                        <?php endif; ?>
                    </div>
                    
                </div>
                <div class="pagination-part">
                    <?php if($the_total_data): ?>
                        <?php foreach($the_total_data as $data): ?>
                            <button id="slider-pagination"></button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="total-price-part">
                    <h1>TOTAL</h1>
                    <?php if($the_total_price): ?>
                        <h1><?php echo htmlspecialchars($the_total_price) ?>&euro;</h1>
                    <?php else: ?>
                        <h1>0&euro;</h1>
                    <?php endif; ?>
                </div>
            </div>
            <div class="right-side-cart">
                <div class="title-form">
                    <h1>Fill Those With Your Info:</h1>
                    <div class="form-part">
                        <div class="form-input">
                            <input type="text" placeholder='Your Name' id='nameInput'>
                        </div>
                        <div class="form-input">
                            <input type="email" placeholder='Email' id='emailInput'>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder='Zip Code' id='zipCodeInput'>
                        </div>
                        <div class="form-input">
                            <div class="dropdown-tag">
                                <button id='myButton'>Options</button>
                                <div class="dropdown-div">
                                    <div class="options paying">
                                        <p>PayPal</p>
                                        <div class="line-down"></div>
                                    </div>
                                    <div class="options paying">
                                        <p>CashApp</p>
                                        <div class="line-down"></div>
                                    </div>
                                    <div class="options">
                                        <p>Credit Cart</p>
                                        <div class="credit-cart-dropdown">
                                            <div class="credit-cart-options paying">
                                                <p>Visa Cart</p>
                                            </div>
                                            <div class="credit-cart-options paying">
                                                <p>Nlb Bank</p>
                                            </div>
                                            <div class="credit-cart-options paying">
                                                <p>Teb Bank</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="added-option"></div>
                                    <div class="confirm-button">
                                        <button>Confirm Order</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="form-input confirm">
                            <div class="confirmed-input">
                                <input type="text" class='confirm-input' >
                            </div>
                        </div>
                        <div class="form-input">
                            <div class="confirm-button">
                                <button id='confirmOrderButton'>Confirm Order</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src='cart.js'></script>
</html>