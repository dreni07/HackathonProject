<?php 

    include_once('../authentication/sessions.inc.php');

    // require 'productSuggested.php';


    // if($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_SESSION['adminId'])){
    //     header('Location:../authentication/admin.html');
    // }

    if(!(isset($_SESSION['adminId']))){
        header('Location:../authentication/logInAdmin.html');
    }

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

// $the_username = $_SESSION['admin_username'];


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


function seeNews($the_date){
    try{
        require '../authentication/db.inc.php';

        $first_sql = 'SELECT * FROM news WHERE news_date >= :old_date;';
        $the_sql = 'SELECT * FROM news;';

        $final_query = $the_date ? $first_sql : $the_sql;

        $preparing = $pdo->prepare($final_query);
        
        if($the_date){
            $preparing->bindParam(':old_date',$the_date);
        }

        $preparing->execute();

        $fetched_data = $preparing->fetchAll(PDO::FETCH_ASSOC);

        if($fetched_data){
            return $fetched_data;
        }

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

}

$website_news = seeNews($currDate) ? seeNews($currDate) : [];

    
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .container-page{
            width:100%;
            height:100%;
            display:flex;
            justify-content:center;
        }

        .container-page .container-content{
            width:90%;
            height:100%;
        }

        .container-page .container-content .container-page-nav{
            display:flex;
            justify-content:space-between;
        }

        .container-page .container-content .container-page-nav .searchbar{
            display:flex;
            align-items:center;
            position:relative;
        }

        .searchbar img{
            cursor:pointer;
        }

        .searchbar .tooltip{
            height:70px;
            width:120px;
            background-color:#f9dbe0;
            font-family:'Athiti';
            font-weight:1000;
            font-size:14px;
            border-radius:12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
            position:absolute;
            top:80%;
            left:50%;
            transform:translateX(-50%);
            opacity:0;
            transition:.5s ease-in-out;
            display:flex;
            align-items:center;
            text-align:center;
        
        }

        .searchbar .tooltip::before{
            content:'';
            position:absolute;
            top:0;
            left:50%;
            transform:translate(-50%,-100%);
            height:0;
            width:0;
            border-left:7px solid transparent;
            border-right:7px solid transparent;
            border-bottom:8px solid #f9dbe0;
            border-top:7px solid transparent;
        }

        .searchbar:hover .tooltip{
            opacity:1;
        }

        .searchbar .order-notf{
            position:absolute;
            top:20%;
            right:0;
            color:white;
            font-size:13px;
            height:20px;
            width:20px;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            transform:scale(1.03);
        }

        .another_back{
            background-color:rgb(253, 84, 84);
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


        a{
            text-decoration:none;
            color:#333;
        }

        .notifying-message p{
            color:#333;
            font-family:'Anaheim';
            font-weight:500;
            position:absolute;
            top:5%;
            left:50%;
            transform:translateX(-50%);
            font-size:13px;
        }
       

        @media screen and (min-width:1500px){
            .container .nav-bar .profile-admin{
                height:70px;
            }
            p:not(.fun-stat){
                font-size:30px;
            }
            .fun-stat{
                font-size:40px;
            }
            span{
                font-size:20px;
            }
        }






    </style>


</head>
<body>
    <div class="notifying-message">
        <p>Every 5 Interactions Products,Get AI Will Add A New Product</p>
    </div>

    <div class="notification-added">
        <div class="text">
            <p>AI just Added A Product To The Database!</p>
        </div>
        <div class="button">
            <button id='okBtn'>Ok</button>
        </div>
    </div>



    <div class="container">

        <div class="nav-bar">
            <div class="profile-admin">
                <p>Dreni<br><span>Welcome To Your Page!</span></p>
                
            </div>
            <div class="navigation-tools">
                <div class="nav-part">
                    <div class="navigation-div active">
                        <i class='material-icons icon'>home</i>
                        <p><a href="adminPage.php">Home</a></p>
                    </div>
                </div>
                <div class="nav-part">
                    <div class="navigation-div">
                        <i class='material-icons icon'>add</i>
                        <p><a href="AIImpacted.php">AI Analys</a></p>
                    </div>
                </div>
                <div class="nav-part">
                    <div class="navigation-div">
                        <i class='material-icons icon'>pending</i>
                        <p><a href="productsByAI.php">AI Products</a></p>
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
                                        <p class='fun-stat'><?php echo $numberOfTotalOrders ?><br></p>
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
                                        <p class='money fun-stat'><?php echo $total ?>&euro;<br></p>
                                        <p class='percentage fun-stat'><?php echo $the_profit;?>% <i style='font-size:12px;'>profit</i></p>
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
                                        <p class='fun-stat'><?php echo $number_of_active_products?></p>
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
<!-- <script src='adminPage.js'></script> -->
<script>



    
    var money = document.querySelector('.money');
    var percentage = document.querySelector('.percentage');
    function changing(){
        money.onclick = function(){
            money.style.display = 'none';
            percentage.style.display = 'block';
            percentage.onclick = function(){
                money.style.display = 'block';
                percentage.style.display = 'none';
                changing();
            }
        }
    }

    changing();



async function chartsData(){
    try{
        const context = {
            method:'GET',
            headers:{
                'X-Requested-With':'XMLHttpRequest'
            }
        }

        const response = await fetch('getSales.php',context);

        if(!response.ok){
            throw new Error('Something Went Wrong!');
        }

        const answer = await response.json();

        let the_data = answer.data;

        const the_days = Object.keys(the_data);
        const the_orders = Object.values(the_data);

        const canvas_element = document.getElementById('my_canvas').getContext('2d');

        const the_chart = new Chart(canvas_element,{
            type:'line',
            data:{
                labels:the_days,
                datasets:[{
                    label:'Orders:',
                    data:the_orders,
                    borderColor:'#a4b4f7',
                    tension:0.1,
                    lineTension:0.2,
                    pointRadius:3,
                    pointBackgroundColor:'#F7E7A4',
                    pointHoverRadius:7,

                }]
            },
            options:{
                scales:{
                    y:{
                        beginAtZero:true,
                        grid:{
                            borderColor:'#333',
                            borderWidth:1,
                            color:'rgb(225, 225, 225)'
                        }
                    },
                    x:{
                        beginAtZero:true,
                        grid:{
                            borderColor:'#333',
                            borderWidth:5,
                            color:'rgb(225, 225, 225)'
                        }
                    }
                }
            }
        })
    } catch(err){
        console.error(err);
    }
}

chartsData();


async function makeRequestForProduct(){
    try{
        const response = await fetch('productSuggested.php');

        if(!response.ok){
            throw new Error('Something Went Wrong!');
        }

        const answer = await response.json();

        console.log(answer);


        var the_category_name = answer.category_name;
        var the_category_id = answer.category_id;


        var getting = localStorage.getItem('last_interaction_id') ? localStorage.getItem('last_interaction_id') : null;

        if(!getting){
            var new_local_storage = localStorage.setItem('last_interaction_id',answer.last_inserted_id);
        }else{
            getting = parseInt(getting);

            var the_data_for_product_added = {
                product_category:the_category_id,
                product_name:'',
                product_image:'',
                product_price:'',
                product_in_stock:'',
                product_description:'',
                added_by_ai:'Yes'
            };

            if((getting + 4) <= answer.last_inserted_id){

                console.log(getting,'GETTINGGGG');
                console.log(answer.last_inserted_id,'LASSTTT ONEEE');

                localStorage.removeItem('last_interaction_id');
                localStorage.setItem('last_interaction_id',answer.last_inserted_id);

                var chatAIResponse = chatAI(the_category_name);

                
                var the_image = askingAI(the_category_name);


                
                Promise.all([chatAIResponse, the_image]).then((responses) => {
                // Destructure the responses
                    var answerFromAI = responses[0].response;// AI Response


                    var answerFromImage = responses[1];
                    
                    
                    // Process chatAI response
                    var the_response = answerFromAI.split('*');


                    
                    var the_product_name = the_response[0];
                    var the_product_price = the_response[1];
                    var the_product_description = the_response[2]
                    var the_product_in_stock = 10; // Assuming a fixed stock for now

                    // Update the_data_for_product_added
                    the_data_for_product_added.product_name = the_product_name;
                    the_data_for_product_added.product_price = the_product_price;
                    the_data_for_product_added.product_in_stock = the_product_in_stock;
                    the_data_for_product_added.product_description = the_product_description;

                    // Update the image URL
                    var the_url = answerFromImage.urls.raw;
                    the_data_for_product_added.product_image = the_url;

                    var notification_added = document.querySelector('.notification-added');

                    notification_added.style.height = '100px';

                    document.getElementById('okBtn').addEventListener('click',()=>{
                        notification_added.style.height = '0px';
                    })

                    // Now that both promises are resolved, add the data to the database
                    addingToDb(the_data_for_product_added);

                    // Log the final object to check if it's properly populated
                    console.log(the_data_for_product_added);
                }).catch((error) => {
                    console.error('Error processing AI responses:', error);
                });



            }else{
                console.log(getting);
                console.log(answer.last_inserted_id);
            }
        }

        




    } catch(err){
        console.error(err);
    }
}


console.log(localStorage.getItem('last_interaction_id'));

makeRequestForProduct();


async function askingAI(category_name){
    const API_KEY = 'uRrdZGbE8t8-mG-ts1zc-AT3WXM_N948_eH1puHhfMI';

    try{
        const response = await fetch(`https://api.unsplash.com/photos/random?query=${category_name}&client_id=${API_KEY}`)

        if(!response.ok){
            throw new Error('Something Went Wrong!');
        }

        const answer = await response.json();

        return answer;
    } catch(err){
        console.error(err);
    }

    
}




async function chatAI(the_prompt){
    const url = 'https://chatgpt-gpt5.p.rapidapi.com/ask';
    const options = {
        method: 'POST',
        headers: {
            'x-rapidapi-key': 'bf2c880334msh410d33d8e6c100ap1359bfjsn82e023423cc0',
            'x-rapidapi-host': 'chatgpt-gpt5.p.rapidapi.com',
            'Content-Type': 'application/json'
        },
        body:JSON.stringify({
            query: `Give Me A Product About this category ${the_prompt} ONLY THE PRODUCT NAME AND GIVE ME PRODUCT PRICE PRODUCT DESCRIPTION ALL SEPERATED BY * AND DONT GIVE LABELS JUST VALUES AND WHEN YOU GENERATE THE PRICE GENERATE IT WITHOUT THE DOLLAR SIGN JUST THE NUMBER`

        })
    };

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        return result
        console.log(result);
    } catch (error) {
        console.error(error);
    }

    

}


async function addingToDb(the_object_data){
    console.log(the_object_data,'HELLOO');
    const the_data = new FormData();

    the_data.append('product_name',the_object_data.product_name);
    the_data.append('product_price',the_object_data.product_price);
    the_data.append('product_in_stock',the_object_data.product_in_stock);

    the_data.append('product_description',the_object_data.product_description);
    the_data.append('product_image',the_object_data.product_image);
    the_data.append('product_category',the_object_data.product_category);

    the_data.append('added_by_ai',the_object_data.added_by_ai);


    for(let [key,value] of the_data.entries()){
        console.log(key,value);
    }

    try{
        const options = {
            method:'POST',
            body:the_data
        };

        const response = await fetch('addByAI.php',options);
        const answer = await response.json();

        console.log(answer);
    } catch(err){
        console.error(err);
    }
}


var add_news = document.getElementById('add_news');

var the_default = document.querySelector('.default');

add_news.onclick = function(){
    the_default.style.display = 'flex';
}


var the_data_sent = {
    image:'',
    news_title:'',
    news_description:''
};

    


function gettingTheFile(){
        var add_image = document.getElementById('add-image');
        add_image.onchange = function(event){
            var image_name = event.target.files[0];
            var dashboard_news_div = document.querySelector('.dashboard-news-div');
            var drag_drop = document.querySelector('.drag-drop');
            var add_image = document.querySelector('label');
            if(image_name){
                the_data_sent.image = image_name;
                const reader = new FileReader();
                reader.onload = function(e){
                    var new_image_element = document.createElement('img');
                    new_image_element.className = 'news-image';
                    new_image_element.src = e.target.result;
                    drag_drop.append(new_image_element);
                    add_image.style.display = 'None';
                    drag_drop.style.border = 'none';
                }

                reader.readAsDataURL(image_name);
            }

        }


        
}
    
gettingTheFile();

function gettingUserInput(){
    var title = document.getElementById('title').value ? document.getElementById('title').value : '';
    var desc = document.getElementById('desc').value ? document.getElementById('desc').value : '';

    return [title,desc];
}




async function addNews(){

// kit funksionalitet duhem me ja jep submit button
// edhe buttonit momental qe e ka kit funksionalitet
// mduhet me ja bo veq me bo display card-n nfillim 
    var sent_data = document.getElementById('sent_data');
        sent_data.addEventListener('click',function(){

            var [title,desc] = gettingUserInput();

            if(title && desc){
                the_data_sent.news_title = title;
                the_data_sent.news_description = desc;
            }

            if(the_data_sent.news_title && the_data_sent.image && the_data_sent.news_description){
                // make a request to send to the back end the data
                const the_form_data = new FormData();

                the_form_data.append('image_file',the_data_sent.image);
                the_form_data.append('news_title',the_data_sent.news_title);
                the_form_data.append('news_description',the_data_sent.news_description);

                let the_context = {
                    method:'POST',
                    headers:{
                        'X-REQUESTED-WITH':'XMLHttpRequest'
                    },
                    body:the_form_data
                }

                fetch('addNews.php',the_context).then(response=>{
                    return response.text();
                }).then(answer=>{
                    console.log(answer);
                })

                // clean up the data
                the_data_sent.news_title = '';
                the_data_sent.image = '';
                the_data_sent.news_description = '';

                the_default.style.display = 'none';
            }



        })

}

addNews();



async function getNews(){
        try{
            const response = await fetch('seeNews.php');

            if(!response.ok){
                throw new Error('Something Went Wrong!');
            }

            const answer = await response.json();

            console.log(answer);

        } catch(err){
            console.error(err);
        }
    }

getNews();





    
</script>
</html>