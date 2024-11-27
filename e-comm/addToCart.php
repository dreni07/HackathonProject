<?php

function getCategories(){
    try{    
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM categories;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();


        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);

        if($fetched_data){
            return $fetched_data;
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    return [];
}

$all_categories = getCategories();

function product_data(){
    if(isset($_GET['product_id'])){
        $the_product_id = $_GET['product_id'];
        try{
            require '../authentication/db.inc.php';
            $the_sql_query = 'SELECT * FROM Products INNER JOIN categories ON Products.product_category = categories.category_id WHERE Products.product_id = :product_id;';
            $the_preparing = $pdo->prepare($the_sql_query);
            $the_preparing->bindParam(':product_id',$the_product_id);
            $the_preparing->execute();
    
            $fetching = $the_preparing->fetch(PDO::FETCH_ASSOC);
    
        } catch(PDOException $e){
            die('Failed Because Of '.$e->getMessage());
        }
    
        if($fetching){
            return $fetching;
        }else{
            return ['success'=>'No Data Returned'];
        }
    }
}
$the_products = product_data();

function order_handling($the_quantity){
    $the_products = product_data();
    $the_product_id = $the_products['product_id'] ?? null;
    try{
        $the_product_id = $the_products['product_id'];
        require '../authentication/sessions.inc.php';
        require '../authentication/db.inc.php';
        $user_id = $_SESSION['userId'];
        $the_sql_query = 'INSERT INTO Orders (id_product,id_user,order_date,order_quantity) VALUES (:id_product,:id_user,CURDATE(),:order_quantity);';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->bindParam(':id_product',$the_product_id);
        $the_preparment->bindParam(':id_user',$user_id);
        $the_preparment->bindParam(':order_quantity',$the_quantity);
        $the_preparment->execute();

        $the_row_count = $the_preparment->rowCount();
        $the_last_row = $pdo->lastInsertId();
    } catch(PDOException $e){
        die('Failed Because Of '.$e->getMessage());
    }
    
    if($the_row_count){
        return ['row_id'=>$the_last_row];
    }else{
        return False;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['quantity'])){
        $the_quantity = $_POST['quantity'];
        $the_order_in_db = order_handling($the_quantity);
        if($the_order_in_db){
             if(addToCart($the_order_in_db['row_id'])){
                echo json_encode(['success'=>'True']);
            }else{
                echo json_encode(['success'=>'Something Went Wrong']);
            }
        }
    }
}


function addToCart($the_order_id){
    try{
        require '../authentication/db.inc.php';
        $sql = 'INSERT INTO cart (id_order) VALUES (:id_order);';
        $preparment = $pdo->prepare($sql);
        $preparment->bindParam(':id_order',$the_order_id);
        $preparment->execute();
        $the_row_cc = $preparment->rowCount();
    } catch (PDOException $e){
        die('Failed Inserting Because Of '.$e->getMessage());
    }

    if($the_row_cc){
        return True;
    }else{
        return False;
    }
}

$the_product_id = $_GET['product_id'];

$the_product_id_category = $the_products['product_category']; # this gets the product category id



function isValidUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}







// ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim|Roboto Slab|Athiti|Cabin Condensed|Lora|Montserrat|Merriweather|Brusher|Pacifico">

    <style>

        body{
            margin:0;
            padding:0;
        }
        .upper-nav{
            position:absolute;
            top:0;
            height:40px;
            width:100%;
            background-color:rgb(0, 49, 0);
            display:grid;
            grid-template-columns:repeat(3,1fr);
        }

        .upper-nav .phone-part{
            display:flex;
            justify-content: center;
            align-items:center;
        }
        .upper-nav .phone-part p{
            color:white;
            font-family:'Anaheim';
            font-weight:500;
            opacity:0.9;
            font-size:15px;
        }
        .upper-nav .phone-part img{
            padding-right:6px;
        }

        .upper-nav .free-part{
            display:flex;
            align-items:center;
            justify-content: center;
        }
        .upper-nav .free-part span{
            color:white;
            font-family:'Anaheim';
            font-weight:500;
            opacity:0.9;
            font-size:15px;
        }
        .upper-nav .free-part a{
            text-decoration-color: white;
            color:white;
            font-family:'Anaheim';
            padding-left:5px;
            font-weight:500;


        }

        .upper-nav .location-part{
            display:flex;
            justify-content:center;
            align-items:center;
        }


        .upper-nav .location-part > div{
            margin:0 8px;
            position:relative;
        }
        .upper-nav .location-part > div > p{
            color:white;
            font-family:'Anaheim';
            font-weight:500;
            opacity:0.8;
        }

        .upper-nav .location-part .language .language-dropdown{
            position:absolute;
            top:90%;
            height:100px;
            width:100%;
            background-color:#fefe72;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
            display:grid;
            grid-template-rows:1fr 1fr;
            opacity:0;
            transition:.5s ease-in-out;
        }




        .upper-nav .location-part .language .language-dropdown > div{
            display:flex;
            justify-content:center;
            align-items:center;
            cursor:pointer;
            transition:.5s ease-in-out;
            position:relative;
        }

        .upper-nav .location-part .language .language-dropdown > div:hover{
            background-color:white;
        }

        .upper-nav .location-part .language .language-dropdown > div:hover p{
            color:#d5d500;
            text-decoration:underline;
            text-decoration-color:#333;
        }

        .underline{
            height:1px; width:100%;
            position:absolute;
            bottom:0;
            background-color:#333;

        }

        .upper-nav .location-part .language .language-dropdown > div > p{
            color:#333;
            font-family:'Anaheim';
            font-weight:500;
        }

        .under-nav{
            height:120px;
            width:100%;
            display:grid;
            grid-template-columns:1fr 1fr 1fr;
            background-color:white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.121), 0 4px 24px rgba(0, 0, 0, 0.19);



        }

        .under-nav .logo-categories{
            display:flex;
            align-items: center;    
            margin-top:15px;
        }

        .under-nav .logo-categories .logo h1{
            color:rgb(1, 71, 1);
            font-family:'Athiti';
            font-weight:1000;
        }

        .under-nav .logo-categories > div{
            margin:0 20px;
        }

        .categories{
            position:relative;
        }

        .categories h2{
            color:#333;
            font-weight:500;
            font-family:'Roboto Slab';
            font-size:13px;
            padding-top:10px;
            cursor:pointer;

        }

        .categories .dropdown-categories{
            position:absolute;
            top:100%;
            height:150px;
            width:100%;
            background-color:white;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2), 0 8px 24px rgba(0, 0, 0, 0.19);
            overflow:auto;
            opacity:0;
            transition:.5s ease-in-out;
        }   

        .categories .dropdown-categories > div{
            height:25%;
            width:100%;
            position:relative;
        }

        .categories .dropdown-categories > div .split-line{
            position:absolute; bottom:0;
            height:1px;
            width:100%;
            background-color:#333;
        }
        .categories .dropdown-categories > div >p{
            font-size:12px;
        }

        .categories:hover .dropdown-categories{
            opacity:1;
        }

        .categories .dropdown-categories::-webkit-scrollbar{
            width:6px;
            background-color:transparent;
        }
        .categories .dropdown-categories::-webkit-scrollbar-thumb{
            width:8px;
            background-color:#333;
            border-radius:2px;
            cursor:grabbing;
        }

        .categories .dropdown-categories > div > p{
            color:#333;
            font-family:'Anaheim';
            font-weight:500;
            font-size:15px;
            text-align:center;
            cursor:pointer;
        }

        .categories .dropdown-categories > div > p:hover{
            text-decoration:underline;
            text-decoration-color:#333;
            font-weight:1000;
        }

        .cart-account{
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .cart-account > div{
            margin-top:20px;
            display:flex;
        }
        .cart-account > div > div{
            margin:0 10px;
            cursor:pointer;
        }

        .cart-account > div > div:nth-child(2){
            padding-top:10px;
        }
        .cart-account > div > div > button{
            color:#333;
            font-family:'Roboto Slab';
            font-weight:500;
            background:transparent;
            border:none;
            font-size:18px;
        }
        .cart-account > div > div > span{
            color:#333;
            font-family:'Roboto Slab';
            font-weight:500;
        }
        .container-products{
            width:100%;
            height:600px;
            display:flex;
        }
        .container-products .container-product-title{
            width:100%;
            margin:0 20px;
        }
        .container-products .container-product-title .container-categories{
            margin-top:20px;
        }
        .container-products .container-product-title .container-categories span:nth-child(2){
            color:#333;
            font-family:'Anaheim';
            font-weight:500;
            opacity:0.8;
        }
        .container-products .container-product-title .container-categories span:nth-child(1){
            color:#333;
            font-family:'Anaheim';
            font-weight:1000;
            opacity:1;
        }

        .container-product-title .product-details{
            height:400px;
            width:100%;
            display:grid;
            grid-template-columns:1fr 1fr;
        }
        .container-product-title .product-details > div{
            margin-top:20px;
        }
            
        .container-product-title .product-details .product-details-image{
            display:flex;
            justify-content:center;
            align-items:center;
            background-color:rgb(240, 240, 240);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
            border-radius:4px;

        }

        .product-details-image img{
            border-radius:6px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
            cursor:pointer;
            transition:.3s ease-in-out;

        }

        .product-details-image img:hover{
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2), 0 20px 24px rgba(0, 0, 0, 0.19);
            transform:scale(1.02);
            -webkit-filter:grayscale(30%);
        }

        a{
            text-decoration:none;
            color:#333;
        }

        .container-products .product-details .product-details-text{
            display:flex;
            justify-content:center;
            height:100%;
            width:100%;
        }
        .container-products .product-details .product-details-text .all-details{
            width:70%;
            display:flex;
            flex-direction:column;
        }
        .all-details > div:nth-child(1){
            display:flex;
            align-items:center;
            flex-direction:column;
            text-align:center;
        }
        .all-details > div:nth-child(1) h1{
            color:#333;
            font-family:'Roboto Slab';
            font-weight:1000;
            font-size:22px;

        }
        .all-details > div:nth-child(1) p{
            color:#333;
            font-family:'Anaheim';
            font-weight:500;
            opacity:0.9;
            font-size:14px;
            white-space:wrap;
        }

        .all-details > div:nth-child(1) .button-similarity button{
            padding:10px 16px;
            border:1px solid black;
            border-radius:20px;
            background-color:transparent;
            color:#333;
            font-family:'Roboto Slab';
            font-weight:500;
            cursor:pointer;
        }

        .all-details > div:nth-child(1) .button-similarity{
            position:relative;
        }
        .button-similarity .tooltip{
            height:80px;
            width:120px;
            background-color:#D2B48C;
            position:absolute;
            top:0;
            right:0;
            transform:translateX(120%) translateY(-30%);
            border-radius:4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 12px rgba(0, 0, 0, 0.19);
            opacity:0;
            transition:.5s ease-in-out;
        }

        .button-similarity .tooltip::before{
            content:'';
            position:absolute;
            top:50%;
            left:-5%;
            transform:translate(-50%,-50%);
            border-right:7px solid #D2B48C;
            border-left:6px solid transparent;
            border-bottom:6px solid transparent;
            border-top:6px solid transparent;
        }

        .button-similarity:hover .tooltip{
            opacity:1;
        }
        .price-description{
            width:100%;
            display:flex;
            justify-content:center;
            padding-top:20px;
        }
        .price-description p{
            color:black;
            font-family:'Roboto Slab';
            font-weight:500;
            font-size:20px;
        }

        .item-description{
            width:100%;
            display:flex;
            height:100px;
            align-items:center;
            justify-content:space-around;
        }
        .item-description .button-counter{
            height:40px;
            width:120px;
            border-radius:30px;
            background-color:rgb(245, 245, 245);
            display:flex;
            justify-content:space-evenly;
            align-items:center;
        }
        .item-description .button-counter p:nth-child(odd){
            color:rgb(0, 49, 0);
            font-family:'Roboto Slab';
            cursor:pointer;
        }
        .item-description .button-counter p:nth-child(even){
            color:#333;
            font-family:'Roboto Slab';
            cursor:pointer;
        }
        .item-description .items-left p{
            font-family:'Athiti';
            font-weight:500;
            color:#333;
        }
        .button-ordering{
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .button-ordering button{
            padding:12px 25px;
            border-radius:25px;
            background-color:#D2B48C;
            color:white;
            font-family:'Roboto Slab';
            font-weight:500;
            border:1px solid #D2B48C;
            cursor:pointer;
            position:relative;
            transition:.5s ease-in-out;
        }
        .button-ordering button:hover{
            background-color:transparent;
            color:#D2B48C;
            border:1px solid #D2B48C;

        }
        .delivery-description{
            padding-top:20px;
            height:100px;
            width:100%;
            display:flex;
            flex-direction: column;
        }
        .delivery-description > div{
            height:100%;
            width:100%;
            background-color:rgb(238, 238, 238);;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 24px rgba(0, 0, 0, 0.19);
            border-radius:6px;
            margin:5px 0;
        }
        .delivery-description > div{
            display:grid;
            grid-template-rows:2fr 1fr;
        }

        .image-into span{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            padding-left:10px;
            letter-spacing:1px;
        }

        .similar-products{
            padding-top:30px;
            /* max-height:500px; */
            height:auto;
        }
        .similar-products h2{
            padding-left:20px;
            color:#333;
            font-family:'Athiti';
            font-weight:500;
            position:relative;
            width:fit-content;
        }

        .similar-products h2::before{
            content:'';
            position:absolute;
            bottom:0;
            left:12%;
            width:50%;
            height:1px;
            background-color:#333;
        }


        .similar-products-container{
            width:100%;
            display:flex;
            height:100%;
            justify-content:space-evenly;
            flex-wrap:wrap;
        }

        .similar-products-container > div{
            padding-top:30px;
            width:30%;
            flex-shrink:0; 
            height:auto;
            border:1px solid gray;
            border-radius:2px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2), 0 2px 2px rgba(0, 0, 0, 0.19);
            flex-grow:0;

        }

        .product > div:nth-child(1){
            height:50%;
            display:flex;
            justify-content:center;
            align-items:center;
        } 

        .product > div:nth-child(2){
            height:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
        }
        .product > div:nth-child(2) p{
            color:#333;
            font-weight:1000;
            font-family:'Athiti';
            font-size:20px;
        }
        .product > div:nth-child(2) button{
            color:white;
            font-family:'Athiti';
            font-weight:1000;
            background-color:#e74c3c;
            border:none;
            padding:10px 20px;
            border-radius:4px;
            cursor:pointer;
        }
         .product > div img{
            height:170px;
            width:200px;
            border-radius:12px;
        }
        
        
         

</style>    
</head>
<body>
    
    <!--- Upper Nav ---->

    <p class='<?php echo $the_product_id?> hidden-para' style='display:none;'></p>
    
    <div class="upper-nav">
            <div class="phone-part">
                <p><img src="../../website_images/phone-logo.png" height='10' width='10'>045441654</p>
            </div>
            <div class="free-part">
                <span>Get 50% Off On Selected Items</span>
                <a href="">Shop Now</a>
            </div>
            <div class="location-part">
                <div class="language">
                    <p id='lang-para'>Language</p>
                    <div class="language-dropdown">
                        <div class="langauge-shown">
                            <p>Albania</p>
                            <div class="underline"></div>
                        </div>
                        <div class="langauge-shown">
                            <p>English</p>
                        </div>
                    </div>
                    
                </div>
                <div class="location">
                    <p>Location</p>
                </div>
            </div>
    </div>


    <!--- Under Nav --->

    <div class="under-nav">
            <div class="logo-categories">
                <div class="logo">
                    <a href="../home.php" target='_blank'><h1 style='padding-left:10px;'><img src="../../website_images/shop-logo.png" height='40' width='40' style='position:relative; top:10px; padding-right:10px;'>Shopcart</h1></a>
                </div>
                <div class="categories">
                    <h2>Categories <img src="../../images/down-arrow.png" height='15' width='15' style='position:relative;top:5px;'></h2>
                    <div class="dropdown-categories">
                        <?php foreach($all_categories as $category): ?>
                            <div><p><?php echo htmlspecialchars($category['category_name'])?></p>
                                <div class="split-line"></div>
                            </div>
                                
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="search-bar">
                <!-- <button id='goToCartButton'><a href="cart.php">See Cart</a></button> -->
                
            </div>

            <div class="cart-account">
                <div class="cart-inside-account">
                    <div class="cart">
                        <img src="../../website_images/cart-img.png" height='30' width='30'>
                        <!-- <img src="../website_images/cart-img.png" height='30' width='30' style='position:relative; top:10px;'> -->
                        <button id='seeCart'>Cart</button>
                    </div>
                    <div class="acc">
                        <img src="../../website_images/log-out.png" height='20' width='20' style='position:relative; top:5px;'>
                        <span><a href="../authentication/logOut.php">Log Out</a></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-products">
            <div class="container-product-title">
                <div class="container-categories">
                    <span><?php print_r($the_products['product_name'])?></span>
                    <span><?php print_r($the_products['category_name'])?></span>
                </div>
                <div class="product-details">
                    <div class="product-details-image">
                        <?php if (isValidUrl($the_products['product_image'])): ?>
                            <img src="<?php echo htmlspecialchars($the_products['product_image']) ?>" height='250' width='300'>
                        <?php else: ?>
                            <img src="../../admin/product_image/<?php echo htmlspecialchars($the_products['product_image'])?>" height='250' width='300'/>
                        <?php endif; ?>
                    </div>
                    <div class="product-details-text">
                        <div class="all-details">
                            <div class="title-description">
                                <h1><?php echo htmlspecialchars($the_products['product_name'])?></h1>
                                <p><?php echo htmlspecialchars($the_products['product_description'])?></p>
                                <div class="button-similarity">
                                    <button id='similarProductsButton'>Similar Products</button>
                                    <div class="tooltip">
                                        <p id='para-tooltip'></p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="price-description">
                                <p>Buy This Product For <?php echo htmlspecialchars($the_products['product_price']) ?>&euro;</p>
                            </div>

                            <div class="item-description">
                                <div class="button-counter">
                                    <p id='decrease'>-</p>
                                    <p id='numberDisplay'>0</p>
                                    <p id='increment'>+</p>
                                </div>
                                <div class="items-left">
                                    <p>Only <b id='numberOfProducts'><?php echo htmlspecialchars($the_products['product_in_stock']) ?> Items</b> Left!<br>
                                    Dont miss it!</p>
                                </div>
                            </div>

                            <div class="button-ordering">
                                <button id='addToCartButton'>Add To Cart</button>
                            </div>

                            <div class="delivery-description">
                                <div class="cart-delivery-one">
                                    <div class="image-into" style='display:flex; align-items:center;'>
                                        <img src="../../website_images/delivery-icon.png" height='30' width='30'>
                                        <span>Free Delivery For Everyone</span>
                                    </div>
                                    <div class="description-details" style='display:flex; align-items:center;'>
                                        <p style='font-size:13px; opacity:0.8; font-family:"Anaheim";padding-left:5px;white-space:wrap;'>We Deliver All The Products!You Have 30 Days Time If You Want To Return It</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="similar-products">
            <h2>Similar Products</h2>

            <div class="similar-products-container">

            </div>
        </div>
</body>

<script type="module">





    var button_similarity = document.querySelector('.button-similarity');
    var elementi = document.querySelector('#para-tooltip');
    var addToCartButton = document.getElementById('addToCartButton');

    button_similarity.addEventListener('mouseover',function(){
        var text = 'Looking for something else? Click here!';
        var i = 0;
        if(elementi.innerHTML == ''){
                let my_interval = setInterval(()=>{
                if(i == text.length){
                    clearInterval(my_interval);
                }else{
                    elementi.innerHTML += text[i];
                    i++;
                }
            },200)
            checking_leave(this,my_interval,elementi)
        }
    })
    function checking_leave(button,intervali,elementi){
        button.addEventListener('mouseleave',function(){
            elementi.innerHTML = '';
            clearInterval(intervali);
        })
    }

    function number_of_products(){
        var i = 0;
        var numberOfProducts = parseFloat(document.getElementById('numberOfProducts').textContent.split(' ')[0]);
        var increment_button = document.getElementById('increment');
        var decrease_button = document.getElementById('decrease');
        var numberDisplay = document.getElementById('numberDisplay');

        increment_button.addEventListener('click',function(){
            i++;
            if(i > numberOfProducts){
                i = numberOfProducts;
            }
            numberDisplay.textContent = i;

        })

        decrease_button.addEventListener('click',function(){ 
            i--;
            if(i < 0){
                i = 0;
            }
            numberDisplay.textContent = i;
        })
        
    }

    number_of_products();

    function addProductToCart(){
        var addToCartButton = document.getElementById('addToCartButton');
        addToCartButton.addEventListener('click',()=>{
            var numberDisplay = parseFloat(document.getElementById('numberDisplay').textContent);
            if(numberDisplay > 0){
                const the_form_data = new FormData();
                the_form_data.append('quantity',numberDisplay);
                var the_context = {
                    method:'POST',
                    body:the_form_data
                }
                fetch(window.location.href,the_context).then(response=>{
                    if(!response.ok){
                        throw new Error('Failed');
                    }
                    return response.json();
                }).then(answer=>{
                    var the_answer = answer;
                    //  now alert to the user that the product was added to cart
                    console.log(answer)
                }).catch(err=>{
                    console.error(err);
                })
            }
        })
    }

    addProductToCart();


    var hidden_para = document.querySelector('.hidden-para');
    var the_classes = Array.from(hidden_para.classList);
    var similar_products_container = document.querySelector('.similar-products-container');

    function gettingSimilarProducts(){
        var the_product_id = parseInt(the_classes[0]);
        var the_endpoint = `../similarProducts.php?product_id=${the_product_id}`;
        fetch(the_endpoint).then(response=>{
            return response.json();
        }).then(answer=>{
            var the_similar_products = answer.data;
            if(Array.isArray(the_similar_products)){
                console.log(answer);
                var similarProductsButton = document.getElementById('similarProductsButton');
                displayingProducts(the_similar_products);
            }else{
                var new_element = document.createElement('p');

                new_element.innerHTML = 'No Similar Products';

                similar_products_container.append(new_element);

            }
        })
    }

    gettingSimilarProducts();


    function displayingProducts(the_similar_products){
      
        the_similar_products.forEach((product,index)=>{
            var main_product_div = createElement('div','',similar_products_container);
            var image_div = createElement('div','',main_product_div);
            var text_button_div = createElement('div','',main_product_div);
            var paragraph_name = createElement('p','',text_button_div);
            var button_view = createElement('button','',text_button_div);
            var product_image = createElement('img','',image_div);
            

            main_product_div.className = 'product';


            if(validURL(product.product_image)){
                product_image.src = product.product_image;
            }else{
                product_image.src = `../../admin/product_image/${product.product_image}`;
            }

            paragraph_name.innerHTML = product.product_name;
            button_view.textContent = 'Add To Cart';

            button_view.addEventListener('click',function(){
                window.location.href = `addToCart.php?product_id=${product.product_id}`;
            })




        })
    }
   

    function createElement(elementName,elementContent,element_parent){
        var creating = document.createElement(elementName);
        if(elementContent){
            creating.innerHTML = elementContent;
        }
        element_parent.append(creating);

        return creating;
    }


    var goToCartButton = document.getElementById('seeCart');

    goToCartButton.addEventListener('click',function(){
        window.location.href = "http://localhost/hackathonproject/e-comm/cart.php"
    })

    function validURL(url){
        try{    
            const newUrl = new URL(url);
            return true;
        }catch(err){
            console.error(err);
            return false;
        }
    }


</script>
</html>
