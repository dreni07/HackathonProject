<?php
if(isset($_SESSION['userId'])){
    header('Location:../e-comm/home.php');
}



function all_categories(){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM categories;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();

        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }


    if($fetched_data){
        return $fetched_data;
    }
}

$the_categories = all_categories() ? all_categories() : [];


class gettingDate{
public static function currDate(){
    $current_date = new DateTime();
    $the_formated = $current_date->format('Y-m-d');
    return $the_formated;
}
}

$new_instance = new gettingDate();
$currDate = $new_instance->currDate();


function gettingTotalOrders(){
    try{
        require '../authentication/db.inc.php';

        $order_completion = 'Accepted';

        $the_sql = 'SELECT COUNT(*) FROM orders WHERE order_completion = :order_completion;';
        $preparment = $pdo->prepare($the_sql);
        $preparment->bindParam(':order_completion',$order_completion);
        $preparment->execute();

        $fetched = $preparment->fetch(PDO::FETCH_ASSOC);

        if($fetched){
            return $fetched;
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }


    return;
}

$numberOfTotalOrders = gettingTotalOrders() ? gettingTotalOrders()['COUNT(*)'] : 'No Orders';



function getCurrentDate(){
    $the_data = date('y-m-d');
    return $the_data;
}
$dict_with_months = [
    '01'=>'January',
    '02'=>'February',
    '03'=>'March',
    '04'=>'April',
    '05'=>'May',
    '06'=>'June',
    '07'=>'July',
    '08'=>'August',
    '09'=>'September',
    '10'=>'October',
    '11'=>'November',
    '12'=>'December'
];

$the_current_date = getCurrentDate();
$into_string = (string)$the_current_date;
$the_month  = explode('-',$into_string);
$get_the_month_value = $dict_with_months[$the_month[1]];

$full_day = "$the_month[2] $get_the_month_value/$the_month[0]";

function get_total_money(){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM orders INNER JOIN products ON orders.id_product = products.product_id;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();

        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);

        $the_total_money = the_calculation($fetched_data);

        if($the_total_money){
            return $the_total_money;
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    return;
}


function the_calculation($the_data){
    $total_money_made = [];
    foreach($the_data as $data){
        $the_price = $data['product_price'];
        $the_order_quantity = $data['order_quantity'];

        $the_total_for_order = $the_price * $the_order_quantity;
        $total_money_made[] = $the_total_for_order;
    }

    $the_total_number = total_number($total_money_made);

    return $the_total_number;
}

function total_number($money_data){
    $total_number = 0;

    foreach($money_data as $money){
        $total_number += $money;
    }
    
    return $total_number;
}

$total = get_total_money();


function active_products(){
    try{
        require '../authentication/db.inc.php';

        $the_sql = 'SELECT COUNT(*) AS active_products FROM products WHERE product_in_stock > 0;';
        $the_preparment = $pdo->prepare($the_sql);
        $the_preparment->execute();

        $fetching_the_data = $the_preparment->fetch(PDO::FETCH_ASSOC);

        if($fetching_the_data){
            return $fetching_the_data['active_products'];
        }

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    return;
}

$number_of_active_products = active_products() ? active_products() : 'No Products Active';



function get_money_invested(){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT SUM(product_price) AS total_investment FROM products;';
        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();

        $fetched = $the_preparment->fetch(PDO::FETCH_ASSOC);

        if($fetched){
            return $fetched['total_investment'];
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
    return;
}

$total_investment = get_money_invested(); 
$the_percentage = $total + $total_investment; // total money
$profit_money = $total - $total_investment; // profit


$the_profit = round((100 * $total) / $profit_money,2); // profit in percentage





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim|Roboto Slab|Athiti|Cabin Condensed|Lora|Montserrat|Merriweather|Brusher|Pacifico">

    <style>
        body{
            margin:0;
            padding:0;
            background-color:rgb(255, 250, 250);
            overflow:hidden;
        }



        .container{
            height:100vh;
            width:100%;
            display:flex;
        }

        .container .nav-bar{
            height:100vh;
            width:17%;
            background-color:white;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2), 0 4px 18px rgba(0, 0, 0, 0.19);
            transform:scale(1.01);

        }

        .container .nav-bar .profile-admin{
            width:100%;
            height:50px;
            text-align:center;
        }

        .container .nav-bar .profile-admin p{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            font-size:23px;
        }
        .container .nav-bar .profile-admin span{
            font-size:13px;
            color:#333;
            opacity:0.7;
            font-family:'Anaheim';
        }
        .icon{
            color:#333;
            cursor:pointer;
            padding-top:17px;
            margin:0 8px;
        }

        .navigation-tools{
            width:100%;
            height:80%;
            padding-top:50px;
        }
        .navigation-tools .nav-part{
            height:100px;
            width:100%;
            display:flex;
            justify-content:center;
        }
        .navigation-tools .nav-part .navigation-div:not(.active){
            display:flex;
            height:fit-content;
            width:140px;
            border-radius:12px;
            cursor:pointer;
            background:transparent;
            transition:.3s ease-in-out;
        }

        .active{
            display:flex;
            height:fit-content;
            width:140px;
            border-radius:12px;
            cursor:pointer;
            background-color:rgb(191, 248, 191);
        }
        .navigation-div:hover{
            background:rgb(191, 248, 191);
        }

        .navigation-div p{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            white-space:nowrap;
        }






        .container-page .container-content .container-page-nav .title h1{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            height:fit-content;
        }

        .container-page .container-content .container-page-nav .title p{
            color:#333;
            opacity:0.8;
            font-weight:500;
            font-size:15px;
            font-family:'Anaheim';
        }

        .container-page-data{
            height:100%;
            display:grid;
            grid-template-columns:2fr 1fr;
        }

        .container-page-data .dashboards{
            display:grid;
            grid-template-rows:1fr 2fr;
        }

        .container-page-data .dashboard-carts{
            display:flex;
            justify-content:space-between;
        }

        .container-page-data .dashboard-carts .dashboard-cart:not(.dashboard-cart:nth-child(3)){
            height:140px;
            width:200px;
            border-radius:12px;
            background-color:white;
            box-shadow: 0 8px 7px rgba(0, 0, 0, 0.123);
            cursor:pointer;
            transition:.3s ease-in-out;

        }

        .container-page-data .dashboard-carts .dashboard-cart:not(.dashboard-cart:nth-child(3)):hover{
            box-shadow: 0 12px 7px rgba(0, 0, 0, 0.123);
            transform:translateY(-5px);

        }


        .container-page-data .dashboard-carts .dashboard-cart .icon-title{
            width:100%;
            display:flex;
            align-items:center;
            height:30%;
        }

        .icon-title > div{
            padding-left:20px;
        }

        .icon-title > div span{
            color:#333;
            font-family:'Anaheim';
            font-weight:1000;
            letter-spacing:1px;
        }
        .icon-style{
            padding:2px 5px;
            border-radius:2px;
        }

        .dashboard-cart .statistics-info{
            height:70%;
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
            position:relative;

        }

        .dashboard-cart .statistics-info > div p{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            font-size:40px;
            height:fit-content;
        }

        .dashboard-cart .statistics-info > div span{
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,150%);
            font-family:'Anaheim';
            font-weight:500;
            font-size:13px;
            white-space:nowrap;

        }

        .dashboard-cart:nth-child(3){
            position:relative;
            height:140px;
            width:200px;
            border-radius:12px;
            background-color:white;
            box-shadow: 0 8px 7px rgba(0, 0, 0, 0.123);
            transition:.3s ease-in-out;
            cursor:pointer;
        }

        .tooltip-information{
            position:absolute;
            top:-60%;
            background-color:#f9dbe0;
            font-family:'Anaheim';
            font-weight:1000;
            font-size:14px;
            height:70px;
            width:150px;
            border-radius:12px;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2), 0 4px 10px rgba(0, 0, 0, 0.19);
            display:flex;
            text-align:center;
            align-items:center;
            opacity:0;
            transition:.3s ease-in-out;
        }


        .tooltip-information::before{
            content:'';
            position:absolute;
            height:0;
            width:0;
            border-left:6px solid transparent;
            border-right:6px solid transparent;
            border-bottom:6px solid transparent;
            border-top:7px solid #f9dbe0;
            top:100%;
            left:50%;
            transform:translate(-50%,0%);
        }

        .dashboard-cart:nth-child(3):hover .tooltip-information{
            opacity:1;
        }


        .percentage{
            display:none;
        }

        .button-adding{
            width:100%;
            text-align:center;
        }

        .button-adding button{
            padding:8px 25px;
            border:none;
            cursor:pointer;
            font-family:'Athiti';
            font-weight:1000;
            background-color:#a4b4f7;
            color:white;
            border-radius:4px;
        }

        .dashboard-news{
            height:450px;
            width:100%;
            overflow-y:auto;
            overflow-x:hidden;
            display:flex;
            flex-direction: column;
            align-items:center;
        }

        .dashboard-news::-webkit-scrollbar{
            width:8px;
            background:rgb(225, 225, 225);
        }

        .dashboard-news::-webkit-scrollbar-thumb{
            width:8px;
            background:#f9dbe0;
            cursor:grabbing;
        }

        .dashboard-news > div{
            height:45%;
            width:80%;
            background-color:white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 4px 12px rgba(0, 0, 0, 0.19);
            margin:5px;
            border-radius:8px;
            display:flex;
            flex-direction:column;
            align-items:center;
            flex-shrink:0;
            flex-grow:0;

        }

        .dashboard-news .default{
            height:60%;
            display:none;
        }

        .dashboard-news .dashboard-news-div .drag-drop{
            height:40%;
            width:50%;
            border:2px dotted rgb(250, 90, 90);
            margin:5px 0;
            position:relative;
            cursor:pointer;
        }

        .dashboard-news .dashboard-news-div .drag-drop label img{
            cursor:pointer;
        }

        .dashboard-news .dashboard-news-div .drag-drop label{
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            font-family:'Anaheim';
            font-weight:500;
            opacity:0.8;
        }

        .news-image{
            position:absolute;
            top:50%;
            left:50%;
            z-index:1000;
            transform:translate(-50%,-50%);
            height:60px;
            width:60px;
        }

        #title{
            width:160px;
            padding:6px 18px;
            border:none;
            background-color:azure;
            font-family:'Athiti';
            font-weight:500;
            border:1px solid #f9dbe0;
            outline:none;
        }

        #title::placeholder{
            font-family:'Athiti';
            font-weight:1000;
            opacity:0.8;
        }

        #desc{
            width:160px;
            padding:10px 18px;
            border:none;
            background-color:azure;
            font-family:'Athiti';
            font-weight:500;
            border:1px solid #f9dbe0;
            outline:none;
        }

        .info-inputs input{
            margin:3px 0;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2), 0 2px 4px rgba(0, 0, 0, 0.19);
        }

        .submiting_data{
            height:60px;
            width:100%;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .submiting_data button{
            padding:8px 18px;
            font-family:'Athiti';
            font-weight:1000;
            border-radius:4px;
            border:none;
            cursor:pointer;
            background-color:#a4b4f7;
            color:#333;
        }

        #no-news-alert{
            background:rgb(250,94, 108);
            padding:15px 35px;
            color:white;
            font-family:'Athiti';
            font-weight:1000;
            border-radius:2px;
            box-shadow: 0 6px 6px rgba(0, 0, 0, 0.2), 0 3px 4px rgba(0, 0, 0, 0.19);
            cursor:pointer;

        }

        .title h2{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            font-size:20px;
        }

        .description p{
            white-space:wrap;
            color:#333;
            font-family:'Anaheim';
            opacity:0.8;
        }

        .notification-added{
            position:fixed;
            top:0;
            left:50%;
            transform:translateX(-50%);
            background-color:#f9dbe0;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
            height:0px;
            width:200px;
            transition:.5s ease-in-out;
            z-index:1000;
            overflow:hidden;
        }

        .notification-added .text{
            height:40%;
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
            text-align:center;
        }
        .notification-added .button{
            height:60%;
            width:100%;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .notification-added .button button{
            padding:8px 20px;
            background-color:#333;
            color:white;
            font-family:'Athiti';
            font-weight:1000;
            border:none;
        }

        .notification-added .text p{
            padding-top:5px;
            color:#333;
            font-family:'Anaheim';
            font-weight:1000;
            font-size:15px;
        }



    </style>



</head>
<body>
    <div class="container">
        <div class="nav-bar">
            <div class="profile-admin">
                <p>Dreni<br><span>Welcome To Your Page!</span></p>
                
            </div>
            <div class="navigation-tools">
                <div class="nav-part">
                    <div class="navigation-div active">
                        <i class='material-icons icon'>home</i>
                        <p>Home</p>
                    </div>
                </div>
                <div class="nav-part">
                    <div class="navigation-div">
                        <i class='material-icons icon'>add</i>
                        <p>Add Product</p>
                    </div>
                </div>
                <div class="nav-part">
                    <div class="navigation-div">
                        <i class='material-icons icon'>visibility</i>
                        <p>See Orders</p>
                    </div>
                </div>
                <div class="nav-part">
                    <div class="navigation-div">
                        <i class='material-icons icon'>pending</i>
                        <p><a href="pendingOrders.php">Pending Orders</a></p>
                    </div>
                </div>
             
                
            </div>
        </div>



        <div class="container-page">
            <div class="container-content">
                <div class="container-page-nav">
                    <div class="title">
                        <h1>Dashboard</h1>
                        <p><?php echo $full_day?></p>
                    </div>
                    <div class="searchbar">
                        <img src="../website_images/order-bag.png" height='50' width='50' id='see_orders'>
                        <div class="tooltip">
                            See Here New Orders!
                        </div>
                        <div class="order-notf">
                            
                        </div>
                    </div>
                </div>
                <div class="container-page-data">
                    <div class="dashboards">
                        <div class="dashboard-carts">
                            <div class="dashboard-cart">
                                <div class='icon-title'>
                                    <div class="icon-text">
                                        <i class='fa fa-first-order icon-style' style='color:#333;'></i>
                                        <span>Total Orders</span>
                                    </div>
                                </div>
                                <div class='statistics-info'>
                                    <div class="statistics">
                                        <p><?php echo $numberOfTotalOrders ?><br></p>
                                        <span>See Number Of Orders There!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-cart">
                                <div class="icon-title">
                                    <div class="icon-text">
                                        <i class='fa fa-total'></i>
                                        <span>Total Money</span>
                                    </div>
                                </div>
                                <div class='statistics-info'>
                                    <div class="statistics">
                                        <p class='money'><?php echo $total ?>&euro;<br></p>
                                        <p class='percentage'><?php echo $the_profit;?>% <i style='font-size:12px;'>profit</i></p>
                                        <span>See Total Money Made There!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-cart">
                                <div class="icon-title">
                                    <div class="icon-text">
                                        <i></i>
                                        <span>Active Products</span>
                                    </div>
                                </div>
                                <div class="statistics-info">
                                    <div class="statistics">
                                        <p><?php echo $number_of_active_products?></p>
                                        <span>See Active Products You Have!</span>
                                    </div>
                                </div>

                                <div class="tooltip-information">
                                    Products That Are In Stock!
                                </div>
                            </div>
                        </div>
                        <div class="dashboard">
                            <canvas id='my_canvas' width='500' height='200'></canvas>
                        </div>
                    </div>
                    <div class="articles">
                        <div class="button-adding">
                            <button id='add_news'>Add News</button>
                        </div>
                        <div class="dashboard-news">
                            <div class="dashboard-news-div default">
                                <div class="drag-drop">
                                    <label for="add-image"><img src="../website_images/upload-icon.png" height='30' width='30'></label>
                                </div>
                                
                                <input type="file" id='add-image' style='display:none'>
                                <div class="info-inputs">
                                    <input type="text" placeholder='Title' id='title'><br>
                                    <input type="text" placeholder='Description' id='desc'>
                                </div>

                                <div class="submiting_data">
                                    <button id='sent_data'>Post</button>
                                </div>
                                
                            </div>


                            <?php if(!empty($website_news)): ?>
                                <?php foreach($website_news as $news): ?>
                                    <div class="dashboard-news-div">
                                        <div class="image">
                                            <img src="./news_images/<?php echo htmlspecialchars($news['news_image'])?>" height='65' width='65'>
                                        </div>
                                        <div class="title">
                                            <h2><?php echo htmlspecialchars($news['news_title'])?></h2>
                                        </div>
                                        <div class="description">
                                            <p><?php echo htmlspecialchars($news['news_desc'])?></p>
                                        </div>
                                    </div>
                                
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p id='no-news-alert'>No News Today</p>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</body>
</html>