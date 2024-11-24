<?php 

    include_once('../authentication/sessions.inc.php');

    require 'productSuggested.php';


    // if($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_SESSION['adminId'])){
    //     header('Location:../authentication/admin.html');
    // }

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




// function seeNews($the_date){
//     try{
//         require '../authentication/db.inc.php';

//         $first_sql = 'SELECT * FROM news WHERE news_date >= :old_date;';
//         $the_sql = 'SELECT * FROM news;';

//         $final_query = $the_date ? $first_sql : $the_sql;

//         $preparing = $pdo->prepare($final_query);
        
//         if($the_date){
//             $preparing->bindParam(':old_date',$the_date);
//         }

//         $preparing->execute();

//         $fetched_data = $preparing->fetchAll(PDO::FETCH_ASSOC);

//         if($fetched_data){
//             return $fetched_data;
//         }

//     } catch(PDOException $e){
//         die('Failed Because Of ' . $e->getMessage());
//     }

// }

// $website_news = seeNews($currDate) ? seeNews($currDate) : [];



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






    
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel='stylesheet' href='adminHome.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim|Roboto Slab|Athiti|Cabin Condensed|Lora|Montserrat|Merriweather|Brusher|Pacifico">

</head>
<body>
    <!-- <div>
        <input type="file" id='image_file'>
        <input type="text" id='productName'>
        <select name="" id="category">
            
        </select>

        <input type="number" id='product_price'>
        <input type="number" id='product_in_stock'>


        <button id='addProduct'>Add Product</button>



    </div> -->
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
<!-- <script src='adminPage.js'></script> -->
<script>
    // function addingProduct(){
    //     var getting_image = null;

    //     var image = document.getElementById('image_file');
    //     var product_price = document.getElementById('product_price');
    //     var productName = document.getElementById('productName');
    //     var productCategory = document.getElementById('category');
    //     var product_in_stock = document.getElementById('product_in_stock');

    //     image.onchange = function(event){
    //         getting_image = event.target.files[0];
    //         console.log('hello')
    //         console.log(getting_image);
    //     }


    //     var the_product_data = {
    //         product_name:'',
    //         product_image:'',
    //         product_price:'',
    //         product_category:''
    //     }

    //     var the_product = document.getElementById('addProduct');

    //     the_product.addEventListener('click',function(){
    //         const the_form_data = new FormData();
    //         if(getting_image){

    //             the_form_data.append('image',getting_image);
    //             the_form_data.append('product_name',productName.value);
    //             the_form_data.append('product_category',productCategory.value);
    //             the_form_data.append('product_price',product_price.value);
    //             the_form_data.append('product_in_stock',product_in_stock.value);
    //             console.log('hello')

    //             var the_context = {
    //                 method:'POST',
    //                 headers:{
    //                     'X-REQUESTED-WITH':'XMLHttpRequest'
    //                 },
    //                 body:the_form_data
    //             };

    //             fetch('addProduct.php',the_context).then(response=>{
    //                 return response.text();
    //             }).then(answer=>{
    //                 console.log(answer);
    //             })
    //         }
    //     })
    // }
    // addingProduct();

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


        var getting = localStorage.getItem('last_interaction_id') ? localStorage.getItem('last_interaction_id') : null;

        if(!getting){
            var new_local_storage = localStorage.setItem('last_interaction_id',answer.last_inserted_id);
        }else{
            getting = parseInt(getting);
            if((getting + 4) <= answer.last_inserted_id){
                console.log('This Is Local Storage Variable ', getting);
                console.log('THIS IS THE ANSWER VARIABLE ', answer.last_inserted_id);
                localStorage.removeItem('last_interaction_id');
                localStorage.setItem('last_interaction_id',answer.last_inserted_id);

                var AIresponse = askingAI(the_category_name);
                var chatAIResponse = chatAI(the_category_name);

            }else{
                console.log('Not Achieving!');
            }
        }

        
        // var secondAIresponse = chatAI(the_category_name);




    } catch(err){
        console.error(err);
    }
}


console.log(localStorage.getItem('last_interaction_id'));

makeRequestForProduct();


function askingAI(category_name){
    const apiUrl =   'uRrdZGbE8t8-mG-ts1zc-AT3WXM_N948_eH1puHhfMI';

    fetch(`https://api.unsplash.com/photos/random?query=${category_name}&client_id=${apiUrl}`).then(response=>{
        return response.json();
    }).then(answer=>{
        console.log(answer);
    })
    
}

// async function chatAI(the_category){
//     const url = 'https://chatgpt-api8.p.rapidapi.com/';
//     const options = {
//         method: 'POST',
//         headers: {
//             'x-rapidapi-key': 'e91fed1247msh40f39dca1776a54p144a99jsn64bd354cb6de',
//             'x-rapidapi-host': 'chatgpt-api8.p.rapidapi.com',
//             'Content-Type': 'application/json'
//         },
//         body:JSON.stringify([
//             {
//                 content: 'Hello! Im an AI assistant bot based on ChatGPT 3. How may I help you?',
//                 role: 'system'
//             },
//             {
//                 content: `Give Me A Product That Belongs To This Category ${the_category} and also little description!`,
//                 role: 'user'
//             }
//         ]) 
//     };

//     try {
//         const response = await fetch(url, options);
//         const result = await response.json();
//         console.log(result);
//     } catch (error) {
//         console.error(error);
//     }


// }

async function chatAI(the_category_name){
    const url = 'https://chatgpt-gpt5.p.rapidapi.com/ask';
    const options = {
        method: 'POST',
        headers: {
            'x-rapidapi-key': 'e91fed1247msh40f39dca1776a54p144a99jsn64bd354cb6de',
            'x-rapidapi-host': 'chatgpt-gpt5.p.rapidapi.com',
            'Content-Type': 'application/json'
        },
        body:JSON.stringify({
            query: `Give Me A Product About this category ${the_category_name} ONLY THE PRODUCT NAME `
        }) 
    };

    try {
        const response = await fetch(url, options);
        const result = await response.json();
        console.log(result);
    } catch (error) {
        console.error(error);
    }
}

    
</script>
</html>