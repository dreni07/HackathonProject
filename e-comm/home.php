<?php


include '../authentication/sessions.inc.php';

if(!(isset($_SESSION['userId']))){
    header('Location:../authentication/logIn.html');
}




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

function historySpent(){
    try{
        require '../authentication/db.inc.php';

        $the_user_id = $_SESSION['userId'];

        $the_sql = 'SELECT * FROM orders
        INNER JOIN products ON orders.id_product = products.product_id
        WHERE id_user = :id_user;';
        $the_preparment = $pdo->prepare($the_sql);
        $the_preparment->bindParam(':id_user',$the_user_id);
        $the_preparment->execute();

        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);
        

        if($fetched_data){
            $the_total = calculating_value($fetched_data);

            return $the_total;
        }


    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}

function calculating_value($data){
    $full_values = [];

    foreach($data as $order){
        $the_order_quantity = $order['order_quantity'];
        $product_price = $order['product_price'];

        $full_total = $product_price * $the_order_quantity;

        $full_values[] = $full_total;
    }

    $history_ordered = 0;

    for($i = 0;$i<count($full_values);$i++){
        $history_ordered += $full_values[$i];
    }


    return $history_ordered;

}

$the_history_spent = historySpent() ? historySpent() : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='../css/logIn.css?v=1.0'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Anaheim|Roboto Slab|Athiti|Cabin Condensed|Lora|Montserrat|Merriweather|Brusher|Pacifico">
    <style>
body{
    margin:0;
    padding:0;
    background-color:white;
    position:relative;
    overflow-x:hidden;
}
html{
    scroll-behavior:smooth;
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


.search-bar{
    display:flex;
    justify-content: center;
    align-items:center;
}
.search-bar .search{
    margin-top:30px;
    position:relative;
}

.search .search-bar-results{
    max-height:200px;
    width:100%;
    background-color:white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
    position:absolute;
    z-index:10000;
    display:flex;
    flex-direction:column;
    border-bottom-left-radius:8px;
    border-bottom-right-radius:8px;
    overflow:auto;
}

.search .search-bar-results::-webkit-scrollbar{
    width:8px;
    background-color:transparent;
}

.search .search-bar-results::-webkit-scrollbar-thumb{
    width:8px;
    background-color:#333;
    border-radius:6px;
    cursor:grabbing;
}


.search .search-bar-results > div{
    height:70px;
    width:100%;
    flex-grow:0;
    flex-shrink:0;
    cursor:pointer;
    display:flex;
    justify-content:space-between;
    position:relative;
}



.search .search-bar-results > div > div:nth-child(1){
    padding-left:10px;
}

.search .search-bar-results > div > div:nth-child(1) p{
    color:#333;
    font-family:'Anaheim';
    font-weight:1000;
    font-size:15px;
}

.search .search-bar-results > div > div:nth-child(2){
    display:flex;
    align-items:center;
    padding-right:10px;
}

.search .search-bar-results > div > div img{
    height:60px;
    width:70px;
    border-radius:4px;
    box-shadow: 0 12px 12px rgba(0, 0, 0, 0.2), 0 12px 17px rgba(0, 0, 0, 0.19);
    cursor:pointer;


}


.search,.search input{
    width:100%;
    
}

.search input{
    border:none;
    border-radius:14px;
    padding:8px 16px;
    outline:none;
    background-color:rgb(240, 240, 240);
    font-family:'Roboto Slab';

}

.search input::placeholder{
    color:#333;
    font-family:'Anaheim';
    font-weight:500;
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
.cart-account > div > div > span{
    color:#333;
    font-family:'Roboto Slab';
    font-weight:500;
}



.container{
    height:350px;
    width:100%;
    background-color:rgb(230, 230, 230);
    display:grid;
    grid-template-columns:1fr 1fr;
}


.container .first-half-container .text-button{
    padding-left:20px;
    padding-top:15px;
}

.container .first-half-container .text-button h1{
    color:#333;
    font-family:'Athiti';
    font-weight:1000;
    
}
.container .first-half-container .text-button h1 b{
    color:rgb(0, 49, 0);
}

.container .first-half-container .text-button p{
    color:#333;
    font-family:'Anaheim';
    font-weight:500;
    font-size:18px;
}

.container .first-half-container .text-button button{
    padding:10px 20px;
    color:white;
    font-family:'Roboto Slab';
    font-weight:500;
    background-color:rgb(0, 49, 0);
    border:none;
    border-radius:12px;
    cursor:pointer;
    position:relative;
    overflow:hidden;
}

.container .first-half-container .text-button button::before{
    content:'';
    position:absolute;
    top:50%;
    left:-100%;
    transform:translateY(-50%);
    height:100%;
    width:100%;
    background-color:rgb(162, 230, 162);
    border-radius:12px;
    transition:.3s ease-in-out;
}

.container .first-half-container .text-button button::after{
    content:'';
    background:url('../website_images/more-icon.png');
    background-size:cover;
    background-repeat:no-repeat;
    height:30px;
    width:30px;
    position:absolute;
    top:-100%;
    left:50%;
    transform:translateX(-50%);
    transition:.5s ease-in-out;
}

.container .first-half-container .text-button button:hover::after{
    top:0;
}

.container .first-half-container .text-button button:hover::before{
    left:0;
}

.container .second-half-container{
    display:flex;
    justify-content:start;
    align-items:start;
}


.container .second-half-container > div{
    padding-top:30px;
    margin-left:100px;

}

.container .second-half-container > div .buttons-navigate{
    width:270px;
    display:flex;
    justify-content:space-evenly;
    margin-bottom:10px;
}

.container .second-half-container > div .buttons-navigate button:not(.active){
    padding:6px 14px;
    color:#333;
    font-family:'Roboto Slab';
    font-weight:500;
    cursor:pointer;
    border:none;
    border-radius:6px;
    background:aliceblue;
}

.container .second-half-container .slider > div{
    height:250px;
    width:270px;
    background-color:white;
    position:absolute;
    border-radius:12px;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.112), 0 6px 6px rgba(0, 0, 0, 0.107);

}

.container .second-half-container .slider > div:nth-child(1){
    z-index:1;
}

.active{
    padding:6px 14px;
    color:#333;
    font-family:'Roboto Slab';
    font-weight:500;
    cursor:pointer;
    border:none;
    border-radius:6px;
    background-color:rgb(162, 230, 162);
}

.second-container{
    height:300px;
    width:100%;
    background-color:white;
}
.categories-container{
    width:100%;
    display:flex;
    justify-content:center;
}
.container-cards{
    width:100%;
    height:200px;
    margin:0px 20px;
    display:flex;
    justify-content:space-around;
}

.container-cards .cart-container{
    height:200px;
    width:200px;
    transition:.5s ease-in-out;
    cursor:pointer;
    

}
.cart-container:not(.special-game) p{
    position:absolute;
    top:0;
    left:50%;
    transform:translateX(-50%);
    font-size:16px;
    color:#333;
    font-family:'Roboto Slab';
}
.special-game p{
    position:absolute;
    top:0;
    left:50%;
    font-size:16px;
    transform:translateX(-50%);
    color:white;
    font-family:'Roboto Slab';
    opacity:0.8;
}

.cart-container img{
    border-radius:12px;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2), 0 4px 24px rgba(0, 0, 0, 0.19);
    transition:.5s ease-in-out;

}
.cart-container:hover{
    transform:translateY(-10px);
}
.cart-container:hover img{
    box-shadow:0 4px 4px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19)
}

.second{
    background-color:#fefe72;
}
#image{
    transition:.5s ease-in-out;
}
#paragraph{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-100%);
    color:#333;
    font-family:'Anaheim';
}
span a{
    text-decoration:none;
    color:#333;
}

.product-class-added::before{
    content:'Previously Visited';
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    font-family:'Anaheim';
    font-weight:500;
    font-size:10px;
    opacity:0.8;
}



.active{
    padding:6px 14px;
    color:#333;
    font-family:'Roboto Slab';
    font-weight:500;
    cursor:pointer;
    border:none;
    border-radius:6px;
    background-color:rgb(162, 230, 162);
}

.second-container{
    height:300px;
    width:100%;
    background-color:white;
}
.categories-container{
    width:100%;
    display:flex;
    justify-content:center;
}
.container-cards{
    width:100%;
    height:200px;
    margin:0px 20px;
    display:flex;
    justify-content:space-around;
}

.container-cards .cart-container{
    height:200px;
    width:200px;
    transition:.5s ease-in-out;
    cursor:pointer;
    

}
.cart-container:not(.special-game) p{
    position:absolute;
    top:0;
    left:50%;
    transform:translateX(-50%);
    font-size:16px;
    color:#333;
    font-family:'Roboto Slab';
}
.special-game p{
    position:absolute;
    top:0;
    left:50%;
    font-size:16px;
    transform:translateX(-50%);
    color:white;
    font-family:'Roboto Slab';
    opacity:0.8;
}

.cart-container img{
    border-radius:12px;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2), 0 4px 24px rgba(0, 0, 0, 0.19);
    transition:.5s ease-in-out;

}
.cart-container:hover{
    transform:translateY(-10px);
}
.cart-container:hover img{
    box-shadow:0 4px 4px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19)
}

.second{
    background-color:#fefe72;
}
#image{
    transition:.5s ease-in-out;
}
#paragraph{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-100%);
    color:#333;
    font-family:'Anaheim';
}
span a{
    text-decoration:none;
    color:#333;
}


.third-container{
    height:auto;
    width:100%;
    display:flex;
    align-items:center;
    flex-direction:column;
}
.third-container h1{
    color:#333;
    font-family:'Athiti';
    font-weight:1000;
    position:relative;

}

.third-container h1::before{
    content:'';
    position:absolute;
    height:2px;
    width:20%;
    position:absolute;
    left:50%;
    top:100%;
    transform:translateX(-50%);
    background-color:rgb(0, 49, 0);
}
.container-products{
    padding-top:50px;
    height:100%;
    width:100%;
    margin:0px 20px;
    display:grid;
    grid-template-columns:repeat(4,1fr);
}
.third-container .container-products > div{
    margin:20px 0;
    height:auto;
    display:flex;
    align-items:center;
    flex-direction:column;
    position:relative;
    opacity:0;
    transition:.5s ease-in-out;
}

.third-container .container-products > div .my_div_image{
    height:60%;
    position:relative;
}
.tooltip-info{
    position:absolute;
    top:-40%;
    right:-10%;
    height:60px;
    width:130px;
    background-color:hsl(0, 92%, 67%);
    border-radius:8px;
    display:flex;
    align-items:center;
    text-align:center;
    opacity:0.8;
    color:white;
    font-family:'Athiti';
    font-weight:500;
    font-size:10px;
    opacity:0;
    transition:.5s ease-in-out;
}

.tooltip-info::before{
    content:'';
    position:absolute;
    border-top:5px solid transparent;
    border-bottom:5px solid transparent;
    border-left:5px solid transparent;
    border-right:10px solid hsl(0, 92%, 67%);
    height:0;
    width:0;
    left:59%;
    top:100%;
    transform:translate(-50%,-50%);
}
.third-container .container-products > div .my_div_image .alert-div{
    position:absolute;
    top:5%;
    left:5%;
    height:30px;
    width:70px;
    background-color:hsl(0, 92%, 67%);
    border-radius:10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:13px;
    color:white;
    font-family:'Anaheim';
    font-weight:1000;
    opacity:0;
    transition:.5s ease-in-out;
}

.gray-scale-change{
    -webkit-filter:grayscale(100%);
}
.container-products > div .div_content{
    margin-top:15px;
    height:40%;
    width:100%;

}

.container-products > div .div_content > div:nth-child(1){
    display:flex;
    justify-content:space-evenly;
}

.container-products > div .div_content > div:nth-child(2){
    width:100%;
    display:flex;
    justify-content:center;
}
.container-products > div .div_content > div:nth-child(2) p{
    color:#333;
    font-family:'Anaheim';
    font-weight:1000;
    opacity:0.8;
    font-size:10px;
    cursor:pointer;

}

.container-products > div .div_content > div:nth-child(3){
    display:flex;
    justify-content:center;
}
.container-products > div .div_content > div:nth-child(3) button{
    padding:6px 17px;
    border:1px solid #333;
    color:#333;
    font-family:'Roboto Slab';
    font-weight:500;
    border-radius:12px;
    background-color:transparent;
    cursor:pointer;
    transition:.5s ease-in-out;
}
.container-products > div .div_content > div:nth-child(3) button:hover{
    background-color:rgb(0, 49, 0);
    color:white;
    border:1px solid white;
}
.container-products > div .div_content > div:nth-child(1) p{
    font-weight:1000;
    font-size:12px;
    color:#333;
    font-family:'Roboto Slab';
}

.third-container .container-products > div .my_div_image img{
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
    border-radius:6px;
    transition:.5s ease-in-out;
    cursor:pointer;
}
.third-container .container-products > div .my_div_image img:hover{
    -webkit-filter:grayscale(100%);
    transform:translateY(-10px);
}

.third-container .container-products > div .the_div_heart{
    position:absolute;
    top:0;
    right:20%;
    top:2%;
    border-radius:50%;
    border:1px solid black;
    height:25px;
    width:25px;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    transition:.5s ease-in-out;
}
.third-container .container-products > div .the_div_heart img{
    height:15px;
    width:15px;
}
.active-class{
    background-color:rgb(255, 107, 107);
}

.button{
    margin-bottom:50px;
}
.button button:not(.active-button-pagination){
    margin:0 8px;
    height:45px;
    width:45px;
    border-radius:50%;
    background-color:white;
    border:1px solid rgb(0, 49, 0);
    cursor:pointer;
    color:rgb(0, 49, 0);
    transition:.3s ease-in-out;

}

.active-button-pagination{
    margin:0 8px;
    height:45px;
    width:45px;
    border-radius:50%;
    background-color:rgb(0, 49, 0);
    border:1px solid white;
    cursor:pointer;
    color:white;
}

.read-description{
    height:100vh;
    width:100%;
    position:fixed;
    left:0;
    top:0;
    z-index:-1000;
    display:none;
    justify-content:center;
    align-items:center;
    background-color:rgba(0, 0, 0, 0.0);
    transition:.5s ease-in-out;
    overflow:hidden;
} 

.read-description-class-added{
    display:flex;
    z-index:1000;
    background-color:rgba(0, 0, 0, 0.426);
}

.read-description .description-card{
    height:200px;
    width:250px;
    background-color:#f4f4f1;
    transition:.5s ease-in-out;
    opacity:0;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
    border-radius:2px;
}
.description-card .description-text{
    color:#333;
    font-family:'Anaheim';
    font-weight:1000;

}
.description-card-added{
    opacity:1;
}

.all-div{
    display:none;
}


.slider-container{
    width:100%;
    height:400px;
    display:flex;
    justify-content:space-evenly;
    position:relative;
    overflow:hidden;
}
.slider-container .slider-div{
    padding-top:30px;
    height:270px;
    width:300px;
    position:absolute;
    transform:translateX(-50%);
    transition:.5s ease-in-out;
    border:3px solid rgb(238, 238, 238);
    border-radius:4px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);


}

.slider-container .slider-div > div:nth-child(1){
    height:60%;
    width:100%;
    display:flex;
    justify-content:center;
    align-items:center;
}
.slider-container .slider-div > div:nth-child(2){
    width:100%;
    display:flex;
    justify-content:space-between;
}
.slider-container .slider-div > div:nth-child(2) p{
    color:#333;
    font-family:'Athiti';
    font-weight:1000;
    padding:15px 10px;
}
.slider-container .slider-div > div:nth-child(3){
    width:100%;
    display:flex;
    justify-content:center;
    position:relative;
    bottom:25px;
}
.slider-container .slider-div > div:nth-child(3) button{
    padding:8px 17px;
    background-color:#fefe72;
    border:none;
    border-radius:25px;
    color:#333;
    font-family:'Roboto Slab';
    cursor:pointer;
}
.slider-container .slider-div > div:nth-child(3) button:hover{
    background-color:transparent;
    border:1px solid brown;
}
.slider-container .slider-div img{
    height:200px;
    width:230px;
    border-radius:10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
}

.prev{
    position:absolute;
    height:50px;
    width:50px;
    top:50%;
    transform:translateY(-50%);
    left:1%;
    z-index:10000;
    cursor:pointer;
}
.next{
    height:50px;
    width:50px;
    position:absolute;
    z-index:10000;
    top:50%;
    transform:translateY(-50%);
    right:0;
    cursor:pointer;
}

.title-introduction-section h1{
    padding-left:20px;
    font-size:22px;
    color:#333;
    font-family:'Athiti';
}
.slider-pagination{
    display:flex;
}
.slider-pagination button:not(.active-pagination){
    width:20%;
    height:8px;
    margin:0;
    padding:0;
    border:none;
    background-color:rgb(238, 238, 238);
    transition:.2s ease-in-out;
}

.active-pagination{
    width:20%;
    height:8px;
    margin:0;
    padding:0;
    border:none;
    background-color:rgb(215, 215, 215);
    transition:.2s ease-in-out;

}

.services-page{
    padding-top:50px;
    height:350px;
    width:100%;
    display:flex;
    justify-content:space-around;
}

.service-card{
    height:300px;
    width:350px;
    background-color:#F9F9A9;
    border-radius:4px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
    position:relative;
    opacity:1;
} 

.service-card .icon-part{
    position:absolute;
    right:5%;
    top:7%;
    color:#333;
    font-size:30px;
}

.service-card .service-title{
    padding-left:20px;
}

.service-card .service-title h1{
    color:#333;
    font-family:'Roboto Slab';
    font-weight:1000;
    font-size:27px;
}

.service-card .service-paragraph{
    padding-top:15px;
    width:100%;
    text-align:center;
}

.service-card .service-paragraph p{
    white-space:wrap;
    font-family:'Anaheim';
    font-weight:1000;
}

.service-card .button-service{
    height:60px;
    width:100%;
    display:flex;
    justify-content:center;
    align-items:center;
}

.service-card .button-service button{
    padding:10px 20px;
    background-color:#f4f4f1;
    color:#333;
    font-family:'Roboto Slab';
    font-weight:1000;
    cursor:pointer;
    border:none;
    border-radius:4px;
    box-shadow: 0 8px 8px rgba(0, 0, 0, 0.2), 0 4px 12px rgba(0, 0, 0, 0.19);
    transition:.3s ease-in-out;
}

.service-card .button-service button:hover{
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
}




footer{
    margin-top:100px;
    height:500px;
    width:100%;
    background-color:#b9cdbb;
    display:grid;
    grid-template-rows:1fr 2fr 1fr;
}
footer > div{
    position:relative;
}
footer .second-part-content{
    width:100%;
    display:flex;
    justify-content:space-evenly;
}
footer .second-part-content h2{
    padding-bottom:10px;
    color:#333;
    font-weight:1000;
    font-size:20px;
    font-family:'Roboto Slab';
    letter-spacing:1px;
}
footer .second-part-content > div p{
    color:#333;
    font-family:'Anaheim';
    font-weight:1000;
    opacity:0.8;
    font-size:14px;
    position:relative;
    width:fit-content;
    cursor:pointer;
}
footer .second-part-content > div p::before{
    content:'';
    position:absolute;
    left:50%;
    top:100%;
    transform:translateX(-50%);
    background-color:white;
    width:0%;
    height:1px;
    transition:.3s ease-in-out;
}
footer .second-part-content > div p:hover::before{
    width:100%;
}

.split-line{
    width:100%;
    height:2px;
    background-color:white;
    position:absolute;
    bottom:0;
    z-index:1;
}

.split-line-2{
    width:100%;
    height:2px;
    position:absolute;
    top:0;
    background-color:white;
}

footer .first-part-content{
    display:flex;
    justify-content:center;
    align-items:center;
}
footer .first-part-content > div{
    margin:0 50px;
}

.card-loc{
    display:flex;
    flex-direction:column;
    align-items:center;
}
.card-loc span{
    color:#333;
    font-family:'Athiti';
    font-weight:500;
    opacity:0.8;
    position:relative;
    z-index:1000;
}
.see-more-dropdown{
    position:absolute;
    height:200px;
    width:100%;
    background-color:#F5F5DC;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2), 0 4px 12px rgba(0, 0, 0, 0.19);
    border-radius:6px;
    overflow:auto;
    display:grid;
    grid-template-rows:repeat(4,1fr);
    opacity:0;
    transition:.3s ease-in-out;
}
.see-more-dropdown::-webkit-scrollbar{
    width:6px;
    background-color:transparent;
}
.see-more-dropdown::-webkit-scrollbar-thumb{
    width:6px;
    background-color:#333;
    border-radius:6px;
}
.see-more-dropdown >div{
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
}
.see-more:hover .see-more-dropdown{
    opacity:1;
}

.third-part-content{
    display:flex;
    justify-content:center;
    align-items:end;
    position:relative;
}
.third-part-content .copyright-part p{
    color:#333;
    font-family:'Anaheim';
    font-weight:1000;
    opacity:0.8;
}

.social-media-part{
    position:absolute;
    left:5%;
    top:50%;
    transform:translateY(-50%);
    display:flex;
    flex-direction:row;
}
.social-media-part > div{
    margin:0 10px;
    height:50px;
    width:50px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    transition:.3s ease-in-out;
}
.social-media-part > div i{
    color:#333;
    transition:.5s ease-in-out;
}
.social-media-part >div:hover{
    background-color:#fefe72;
}
.social-media-part > div:hover i{
    color:#333;
    transform:scale(1.05);
}

.navigate-upper-div{
    position:fixed;
    right:-50%;
    bottom:5%;
    height:60px;
    width:60px;
    border-radius:50%;
    background-color:#fefe72;
    z-index:1000;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.19);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    transition:.5s ease-in-out;

}

.navigate-upper-div i{
    font-size:20px;

}

.navigate-upper-div:hover{
    box-shadow: 0 20px 20px rgba(0, 0, 0, 0.2), 0 15px 30px rgba(0, 0, 0, 0.19);
    transform:scale(1.05);
}

.navigate-upper-div-added{
    right:5%;
}





    </style>
</head>
<body>


    <!--- READ DESCRIPTION PART --->


    <div class="read-description">
        <div class="description-card">
            <div class="description-text">
            </div>
        </div>
    </div>


    <!--- NAVIGATE BACK TO HOME PART -->

    <div class="navigate-upper-div">
        <i class='fa fa-arrow-up'></i>
    </div>


    <!--- UPPER NAV BAR --->
    <div class="upper-nav" id='top_page'>
            <div class="phone-part">
                <p><img src="../website_images/phone-logo.png" height='10' width='10'>045441654</p>
            </div>
            <div class="free-part">
                <span>Get 50% Off On Selected Items</span>
                <a href="">Shop Now</a>
            </div>
            <div class="location-part">
                <div class="language">
                    <p id='full-total'>History Spent:<?php echo htmlspecialchars($the_history_spent) ?></p>
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

    <!---UNDER NAV BAR ---->

    <div class="under-nav">
            <div class="logo-categories">
                <div class="logo">
                    <h1 style='padding-left:10px;'><img src="../website_images/shop-logo.png" height='40' width='40' style='padding-right:10px; padding-top:2px; position:relative; top:10px;' >Shopcart</h1>
                </div>
                <div class="categories">
                    <h2>Categories <img src="../images/down-arrow.png" height='15' width='15' style='position:relative;top:5px;'></h2>
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
                <div class="search">
                    <input type="text" placeholder='Search...' id='searchInput'>
                    <div class="search-bar-results">
                        
                    </div>
                </div>
            </div>

            <div class="cart-account">
                <div class="cart-inside-account">
                    <div class="cart">
                        <img src="../website_images/cart-img.png" height='30' width='30' style='position:relative; top:10px;'>
                        <span><a href='./cart.php'>Cart</a></span>
                    </div>
                    <div class="acc">
                        <img src="../website_images/log-out.png" height='20' width='20' style='position:relative; top:5px;'>
                        <span><a href="../authentication/logOut.php">Log Out</a></span>
                    </div>
                </div>
            </div>
        </div>


    <!--- HOME PAGE STARTING --->


    <div class="container">
        <div class="first-half-container">
            <div class="text-button">
                <h1>Shopcart provides <b>products</b> that<br>
                <b>everyone</b> deserves</h1>
                <p>Change the way you shop with our online<br>
                website and application!</p>

                <button id='learnMoreButton'>Learn More >></button>
            </div>
            <div class="mini-slider">

            </div>
        </div>

        <div class="second-half-container">
            <div class="slider-navigation">
                <div class="buttons-navigate">
                    <button class='active' id='button-slider'>Sale</button>
                    <button id='button-slider'>New</button>
                    <button id='button-slider'>Costum</button>
                </div>
                <div class="slider">
                    <div class="cart-inside-slider">
                        <div class="product-text-part" style='display:grid;grid-template-columns:1fr 1fr;'>
                            <h2 style='color:#333;font-family:"Athiti";font-weight:1000; font-size:18px; display:flex;justify-content:center;'>Hand Cream<br>
                                "Sandawha"</h2>
                            <div class="more-info" style='display:flex;justify-content:center;align-items:center; margin-left:10px; margin-top:10px;'>
                                <div class="arrow-div" style='height:40px; width:40px; border-radius:50%; background-color:lightgreen; display:flex;justify-content:center;align-items:center;cursor:pointer;'>
                                    <img src="../website_images/right-top-arrow.png" height='20' width='20'>
                                </div>
                            </div>
                            
                        </div>
                        <div class="product-image-part" style='width:100%;display:flex;justify-content:center;'>
                            <img src="../admin/product_image/hand-cream.jpg" width='220' height='140' style='border-radius:4px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 4px 8px rgba(0, 0, 0, 0.19);' id='image'>
                            <p id='paragraph'></p>
                        </div>
                    </div>
                    <div class="cart-inside-slider">

                        <div class="product-text-part" style='display:grid;grid-template-columns:1fr 1fr;'>
                                <h2 style='color:#333;font-family:"Athiti";font-weight:1000; font-size:18px; display:flex;justify-content:center;'>New Cream<br>
                                    For Black Friday</h2>
                                <div class="more-info" style='display:flex;justify-content:center;align-items:center; margin-left:10px; margin-top:10px;'>
                                    <div class="arrow-div second" style='height:40px; width:40px; border-radius:50%; display:flex;justify-content:center;align-items:center;cursor:pointer;'>
                                        <img src="../website_images/right-top-arrow.png" height='20' width='20'>
                                    </div>
                                </div>
                                
                            </div>
                        <div class="product-image-part" style='width:100%;display:flex;justify-content:center; position:relative;'>
                            <img src="../website_images/new_product.avif" width='220' height='150' style='border-radius:4px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 4px 8px rgba(0, 0, 0, 0.19);' id='image'>
                            <p id="paragraph"></p>
                        </div>
                    </div>
                    <div class="cart-inside-slider">
                        
                    </div>
                </div>
            </div>
        </div>
   </div>

   <!--- SECOND SECTION STARTING --->

   <div class="second-container">
        <h2 id='title-container' style='padding-left:20px;color:#333;font-family:"Roboto Slab";font-weight:500; font-size:18px;'>Shop Our Top Categories</h2>
        <div class="categories-container">
            <div class="container-cards" style='position:relative;'>
                <div class="cart-container" style='position:relative;'>
                    <img src="../website_images/health.avif" alt="" id='myImage' height='170' width='220'>
                    <p>Health</p>
                </div>
                <div class="cart-container" style='position:relative;'>
                    <img src="../website_images/electronics.jpg" alt="" id='myImage' height='170' width='220'>
                    <p>Electronics</p>
                </div>
                <div class="cart-container special-game" style='position:relative;'>
                    <img src="../website_images/games-background.avif" alt="" id='myImage' height='170' width='220'>
                    <p>Games</p>
                </div>
                <div class="cart-container" style='position:relative;'>
                    <img src="../website_images/kitchen-back.avif" alt="" id='myImage' height='170' width='220'>
                    <p>Kitchen</p>
                </div>
                
            </div>
        </div>
        
   </div>


   <!--- PAGINATION STARTING THERE --->

   <div class="third-container">
        <h1>Dive Deep Into Our Products</h1>
        <div class="container-products">
            
        </div>
        <div class="button"></div>
   </div>

   <!--- TOP 5 PRODUCTS SOLD THIS WEEK --->

   <!-- <div class="all-div">
        <div class="title-introduction-section">
            <h1>Top 5 Products Sold This Week!</h1>
        </div>
        <div class="slider-container">
            <div class="slider-holder"></div>
            <div class='prev'><img src="../website_images/prev-arrow.png" height='40' width='40'></div>
            <div class='next'><img src="../website_images/next-arrow.png" height='40' width='40'></div>
        </div>

        <div class="slider-pagination">
            <button class='buttoni-paginate active-pagination'></button>
            <button class='buttoni-paginate'></button>
            <button class='buttoni-paginate'></button>
            <button class='buttoni-paginate'></button>
            <button class='buttoni-paginate'></button>
        </div>
   </div> -->

   <div class="services-page">
        <div class="service-card">
            <div class="service-title">
                <h1>Check Order History</h1>
            </div>
            <div class="service-paragraph">
                <p>This Allows you to quickly view and manage your past purchases.<br>Easily track the status of previous orders, review details like delivery dates and<br> payment methods.</p>
            </div>
            <div class="icon-part">
                <i class='fa fa-camera-retro'></i>
            </div>
            <div class="button-service">
                <button>View Details</button>
            </div>
        </div>


        <div class="service-card">
            <div class="service-title">
                <h1>Return A Product</h1>
            </div>
            <div class="service-paragraph">
                <p>This makes it simple to initiate a return for any eligible items.<br> Whether you're unsatisfied with your purchase or received a damaged product, this<br> feature guides you through the return process.</p>
            </div>
            <div class="icon-part">
                <i class='fa fa-gift'></i>
            </div>
            <div class="button-service">
                <button>View Details</button>
            </div>
        </div>


        <div class="service-card">
            <div class="service-title">
                <h1>See Payment Methods</h1>
            </div>
            <div class="service-paragraph">
                <p>This lets you view and manage the payment options linked to your account.<br> You can easily update or add new cards, set your preferred payment method,<br> and review transaction history.</p>
            </div>
            <div class="icon-part">
                <i class='fa fa-bolt'></i>
            </div>
            <div class="button-service">
                <button>View Details</button>
            </div>
        </div>
   </div>

   <footer>
        <div class="first-part-content">
            <div class="card-loc">
                <img src="../website_images/icon-location.png" height='50' width='50'>
                <span class="see-more">
                    See More...
                    <div class="see-more-dropdown">
                        <div class="dropdown-div">Prishtine</div>
                        <div class="dropdown-div">Gjilane</div>
                        <div class="dropdown-div">Peje</div>
                        <div class="dropdown-div">Albi Mall</div>
                    </div>
                </span>
            </div>
            <div class="card-loc">
                <img src="../website_images/email-shop.png" height='50' width='50'>
                <span>drenllazani10@gmail.com</span>
            </div>
            <div class="card-loc">
                <img src="../website_images/icon-phone.png" height='50' width='50'>
                <span>046129223</span>
            </div>

            <div class="split-line">

            </div>
        </div>
        <div class="second-part-content">
            <div class="content-row">
                <h2>Features</h2>
                <p>User-Friendly</p>
                <p>Fast Transport</p>
                <p>Secure & Reliable</p>
                <p>24/7 Support</p>
                <p>Costumizable Options</p>
            </div>
            <div class="content-row">
                <h2>Company</h2>
                <p>About Us</p>
                <p>Careers</p>
                <p>Privacy Policy</p>
                <p>Terms Of Services</p>
                <p>Copyrights</p>
            </div>
            <div class="content-row">
                <h2>Resources</h2>
                <p>Blog</p>
                <p>Knowledge Base</p>
                <p>FAQ</p>
                <p>Tutorials</p>
                <p>Case Studies</p>
            </div>
        </div>
        <div class="third-part-content">
            <div class="split-line-2"></div>
            <div class="social-media-part">
                <div class="social-media-image">
                    <i class='fa fa-instagram' style='font-size:30px;'></i>
                </div>
                <div class="social-media-image">
                    <i class='fa fa-facebook' style='font-size:30px;'></i>
                </div>
                <div class="social-media-image">
                    <i class='fa fa-linkedin' style='font-size:30px;'></i>
                </div>
            </div>
            <div class="copyright-part">
                <p>Copyright&copy; All Rights Deserved&copy;</p>
            </div>
        </div>


   </footer>

   <button id='speak'>Speak</button>
   <p id='output'></p>
 


</body>
<script src='secondScript.js'></script>
<script>

    // FIRST PAGINATION


    var cart_inside_slider = document.querySelectorAll('.cart-inside-slider');
    var button_slider = document.querySelectorAll('#button-slider');
    function paginate(){
        button_slider.forEach((b,index)=>{
            b.onclick = function(){
                for(let i = 0;i<cart_inside_slider.length;i++){
                    if(button_slider[i].classList.contains('active')){
                        button_slider[i].classList.remove('active');
                    }
        
                    cart_inside_slider[i].style.zIndex = '0';
                }
                cart_inside_slider[index].style.zIndex = '1';
                button_slider[index].classList.add('active');
            }
        })
    }

    paginate();




    // SEARCH BAR 

var search_bar_results = document.querySelector('.search-bar-results');


var the_input = document.getElementById('searchInput');
the_input.addEventListener('keyup',()=>{
    if(the_input.value.length > 0){
        searchBar(the_input.value);
        search_bar_results.style.display = 'flex';
    }else{
        search_bar_results.style.display = 'None';
    }
})

// this will display all the data you looked to before
// when you click on the search bar

the_input.addEventListener('click',function(){
    search_bar_results.style.display = 'flex';
    if(the_input.value.length == 0){
        var the_children = Array.from(search_bar_results.children);
        the_children.forEach(ch=>{
            ch.remove();
        })

        if(getIdsClicked()){
            getIdsClicked().then(answer=>{
                if(answer){
                    console.log(answer,'h');
                    var into_an_array = Array.from(answer.data);
                    var getCookieData = JSON.parse(decodeURIComponent(getCookie('products_clicked')));
                    into_an_array.forEach(a=>{
                        creatingUI(a,into_an_array);
                    });
                    
                }else{
                    console.log('Answer Not Defined');
                }
                
            })
        }
        
    }
    

})


async function searchBar(the_input_value){
        var the_children_divs = search_bar_results.children ? Array.from(search_bar_results.children) : [];

        the_children_divs.forEach((ch)=>{ 
            ch.remove();
        })

        try{
            const response = await fetch(`searchBar.php?product_name=${the_input_value}`);
            if(!response.ok){
                throw new Error('Error During The Proccess');
            }

            const answer = await response.json();

            console.log(answer);



            if(answer.success){
                var array_data = [];
                var answer_data = answer.data;
                console.log(answer_data);
                getIdsClicked().then(answer2=>{
                    if(answer2){
                        console.log(answer2,'h');
                        var into_an_array = Array.from(answer2.data);
                        array_data = into_an_array;
                    }else{
                        console.log('Answer Not Defined');
                    }
                
                })
                answer_data.forEach((a,index)=>{
                    const the_cookie_data = getCookie('products_clicked') ? JSON.parse(decodeURIComponent(getCookie('products_clicked'))) : [];
                    creatingUI(a,array_data);
                })
            }

            console.log(answer);

        } catch(err){
            console.error(err);

        }
        
}




function setCookie(cookie_name,sections_clicked){
    var cookieLifeTime_ = cookieLifeTime();
    document.cookie = `${cookie_name}=${encodeURIComponent(JSON.stringify(sections_clicked))};expires=${cookieLifeTime_};path=/`;
}


function getCookie(cookieName){
    let the_cookie = `; ${document.cookie}`;
    let the_value = the_cookie.split(`; ${cookieName}=`);// 
    if(the_value.length === 2) return the_value.pop().split(';').shift();
}

function settingCookie(){
    const new_cookie = [];
    const cookieName = 'products_clicked';
    var all_sections = document.querySelectorAll('.div-product');
    if(all_sections){
        all_sections.forEach((div_product,index)=>{
            div_product.onclick = function(){
                var get_the_id = this.dataset.id;
                var currentCookie = getCookie(cookieName) ? JSON.parse(decodeURIComponent(getCookie(cookieName))) : null;
                sendingCookieData(get_the_id);
                if(currentCookie){
                    if(!(currentCookie.includes(get_the_id))){
                        currentCookie.push(get_the_id);
                    }
                    setCookie(cookieName,currentCookie);
                }else{
                    new_cookie.push(get_the_id);
                    setCookie(cookieName,new_cookie);
                }
            }
        })
    }
}



async function sendingCookieData(the_id_of_product){
    try{
        const data_to_sent = new FormData();
        data_to_sent.append('product_clicked_id',the_id_of_product);
    
        var the_context = {
            method:'POST',
            body:data_to_sent
        };

        const response = await fetch('getCookieData.php',the_context);
        if(!response.ok){
            throw new Error('Error Occoured');
        }
        const answer = await response.text();
        console.log(answer);
    } catch(err){
        console.error(err);
    }
}

async function getIdsClicked(){
    try{
        const response = await fetch('getCookieData.php');

        if(!response.ok){
            throw new Error('Something Went Wrong!');
        }

        const answer = await response.json();
        console.log(answer);
        if(answer.success == true){
            return answer;
        }

        return;
     

    } catch(err){
        console.error(err);
    }
}


function creatingUI(a,cookieData){
    // THE CODE COMENTED DOWN BELOW WAS RAISING SOME MALICIOUS BUGSSSSSS!!!

    // let the_cookies = JSON.parse(decodeURIComponent(getCookie('products_clicked'))) ? getCookie('products_clicked') : [];

    var all_divs = document.querySelectorAll('.div-product') ? document.querySelectorAll('.div-product') : null;
    var the_array_with_data = all_divs ? Array.from(all_divs).map((the_div)=>{
    var the_data_attr = the_div.dataset.id;
        return parseFloat(the_data_attr);
    }) : [];
    var div_product = document.createElement('div');
    var name_price = document.createElement('div');
    var image_part = document.createElement('div');
    var image = document.createElement('img');
    var product_name = document.createElement('p');
    var product_price = document.createElement('p');


    // send to the page of ordering when clicking on the div

    div_product.addEventListener('click',function(){
        window.location.href = `addToCart.php/?product_id=${a.product_id}`;
    })


    product_name.textContent = a.product_name;
    product_price.textContent = a.product_price.toString() + '$';
    image.src = `../admin/product_image/${a.product_image}`;


    div_product.className = 'div-product';
    div_product.dataset.id = a.product_id;

    name_price.append(product_name);
    name_price.append(product_price);
    image_part.append(image);

    div_product.append(name_price);
    div_product.append(image_part);

    settingCookie();

    var product_ids = [];

    cookieData.forEach((c)=>{
        product_ids.push(c.product_id);
    })

    if(product_ids.includes(a.product_id)){
        div_product.classList.add('product-class-added');
    }
   

    

    console.log(cookieData,'h');

    

    if(!(the_array_with_data.includes(a.product_id))){
        search_bar_results.append(div_product);
    }
}   



function cookieLifeTime(){
    let the_date = new Date();
    the_date.setDate(the_date.getDate() + 7);
    return the_date.toUTCString();
}


function makingPagination(page){
    fetch(`pagination.php?page=${page}`).then(response=>{
        return response.json();
    }).then(answer=>{
        console.log(answer);
        get_all_data(answer.the_data);
        gettingNumberOfPages(answer.total_pages)
    })
}

function get_all_data(data){
    var into_array = Array.from(data);
    var container_products = document.querySelector('.container-products');
    if(Array.from(container_products.children).length !== 0){
        while(container_products.firstChild){
            container_products.removeChild(container_products.firstChild);
        }
        toDisplayAll(container_products,into_array);
    }else{
        toDisplayAll(container_products,into_array);
    }
}

var all_descriptions = [];


function toDisplayAll(the_parent,the_data){
    the_data.forEach((d,index)=>{
        var number_of_products = d.product_in_stock;
        all_descriptions.push(d.product_description);

        var product_card = document.createElement('div');
        var the_div_heart = document.createElement('div');
        var content_div = document.createElement('div');


        for(let j = 0;j<3;j++){
            var div_content = document.createElement('div');
            div_content.className = `div${j+1}`;
            content_div.append(div_content);
        }



            createDomElement(2,'p',[d.product_name,d.product_price],content_div.children[0]);
            var the_button = createDomElement(1,'button',['Add to Cart'],content_div.children[2]);
            the_button.onclick = function(){
                window.location.href = `addToCart.php/?product_id=${d.product_id}`;
            }
            var reading_description = document.createElement('p');
            reading_description.innerHTML = 'Read Description';
            reading_description.className = 'ReadDescription';
            reading_description.onclick = function(){
                var read_description = document.querySelector('.read-description');
                read_description.classList.add('read-description-class-added');
                setTimeout(()=>{
                    document.querySelector('.description-card').style.opacity = 1;
                },200)
                var description_text = document.querySelector('.description-text');
                description_text.innerHTML = d.product_description;
            }

            content_div.children[1].append(reading_description);

            content_div.className = 'div_content';
            the_div_heart.className = 'the_div_heart';
            var the_heart_image = document.createElement('img');
            the_heart_image.src = '../website_images/heart-icon.png';


            // addTransition(the_div_heart,d.product_id);

            checkState(d.product_id).then(ans=>{
                var the_answer = ans;
                if(the_answer.success == 'True'){
                    the_div_heart.classList.add('active-class');
                }
            })



            product_card.className = 'product-card';
            var image_div = document.createElement('div');
            var image = document.createElement('img');
            image_div.className = 'my_div_image';
            var alert_div = document.createElement('div');
            alert_div.className = 'alert-div';
            if(!(number_of_products >= 1)){
                var tooltip_div = document.createElement('div');
                tooltip_div.className = 'tooltip-info';
                tooltip_div.innerHTML = 'Click Here To See Products Similar To This In The Future';
                image_div.append(tooltip_div);
                alert_div.style.opacity = 1;
                image.classList.add('gray-scale-change');
                the_button.disabled = true;
                the_div_heart.disabled = false;
                the_div_heart.classList.add('non-disabled');
            }else{
                the_div_heart.disabled = true;
            }


            alerting_users();

            console.log(`${d.product_id} The Button: ${the_div_heart.disabled}`)
            alert_div.innerHTML = 'Sold Out';
            image.style.height = '170px';
            image.style.width = '200px';


            function isURL(str) {
                // Simple check to see if the string starts with 'http://' or 'https://'
                return /^https?:\/\//.test(str);
            }

            if(isURL(d.product_image)){
                image.src = d.product_image;
            }else{
                image.src = `../admin/product_image/${d.product_image}`;
            }
            
            image_div.append(image);
            image_div.append(alert_div);

            the_parent.append(product_card);
            product_card.append(image_div);
            product_card.append(the_div_heart);
            product_card.append(content_div);
            the_div_heart.append(the_heart_image);

            addTransition(the_div_heart,d.product_id);


        })


        var all_divs = document.querySelectorAll('.product-card');
        if(all_divs){
            window.addEventListener('scroll',()=>{
                animateCards(all_divs);
            })
        }

}
        

function animateCards(cards){
    const the_height = window.innerHeight;
    var container_products = document.querySelector('.container-products');
    const break_point = 70;
    for(let i = 0;i<cards.length;i++){
        var the_client_top = cards[i].getBoundingClientRect().top;
        const is_inter = isInter(cards[i],container_products);
        if(the_height > the_client_top + break_point){
            var time_out = (i+1)*100;
            setTimeout(()=>{
                cards[i].style.opacity = 1;
            },time_out)
        }else{
            var inverse_time_out = (cards.length - i) * 100;
            setTimeout(()=>{
                cards[i].style.opacity = 0;
            },inverse_time_out);
        }
    }
}


function gettingNumberOfPages(numberOfPages){
    for(let i = 0;i<numberOfPages;i++){
        var new_button = document.createElement('button');
        new_button.className = 'button-paginate';
        new_button.textContent = i + 1;
        if(new_button.textContent == 1){
            new_button.classList.add('active-button-pagination');
        }
        var the_div = document.querySelector('.button');
        var the_childrens = the_div.children;
        if(Array.from(the_childrens).length != numberOfPages){
            the_div.append(new_button);
        }
        new_button.onclick = function(){
            var all_new_buttons = document.querySelectorAll('.button-paginate');
            for(let j = 0;j<numberOfPages;j++){
                all_new_buttons[j].classList.remove('active-button-pagination');
            }
            this.classList.add('active-button-pagination');
            makingPagination(i+1);
        }
    }
}

    makingPagination(1);

 


    function addTransition(the_div,product_id){
        if(!(the_div.disabled)){
            the_div.onclick = function(){
            const the_form_data = new FormData();
            the_form_data.append('product_id',product_id);
            this.classList.add('active-class');
            var the_context = {
                method:'POST',
                body:the_form_data
            }
            fetch('wishList.php',the_context).then(response=>{
                return response.json();
            }).then(answer=>{
                console.log(answer);
            });

        }
        }
    }

    function isInter(the_element = null,the_observer){
        var value = true;
        const the_intersection = new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){
                    if(the_element instanceof HTMLElement){
                        the_element.style.opacity = 1;
                    }
                }
            })
        })

        return the_intersection.observe(the_observer);
        
    }




    function createDomElement(the_number_of_elements,the_element_type,the_content_to_be_added,parent_div){
        var new_element;
        for(let j = 0;j<the_number_of_elements;j++){
            new_element = document.createElement(the_element_type);
            if(the_content_to_be_added.length > 0){
                new_element.innerHTML = the_content_to_be_added[j];
                new_element.className = the_content_to_be_added[j].split(' ').join('');
            }
            parent_div.append(new_element);
        }
        return new_element;

    }

    function checkState(product_id){
       return fetch(`checkingState.php/?product_id=${product_id}`).then(response=>{
            return response.json();
       }).then(answer=>{
            return answer;
       });
    }


    function alerting_users(){
        var all_heart_buttons = document.querySelectorAll('.non-disabled');
        all_heart_buttons.forEach((d,index)=>{
            if(!(d.disabled)){
                var the_tooltip = document.querySelectorAll('.tooltip-info');
                d.onmouseover = function(){
                    the_tooltip[index].style.opacity = 1;
                }
                d.onmouseleave = function(){
                    the_tooltip[index].style.opacity = 0;
                }
            }
            
        })
        console.log(all_heart_buttons);
    }


    var navigate_upper_div = document.querySelector('.navigate-upper-div');



    window.addEventListener('scroll',()=>{
        if(this.scrollY > 350){
            navigate_upper_div.classList.add('navigate-upper-div-added');
        }else{
            navigate_upper_div.classList.remove('navigate-upper-div-added');

        }
    })

    navigate_upper_div.addEventListener('click',function(){
        window.location.href = '#top_page';
    })



    var speechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if(speechRecognition){
        var speak = document.getElementById('speak');

        var the_output_element = document.getElementById('output');

        const recognition = new speechRecognition();


        recognition.lang = 'en-US';
        recognition.interimResults = true;
        recognition.maxAlternatives = 1;
        recognition.continuous = true; 


        let full_transcript = '';
        var my_var = '';

        var j = 0;


        recognition.onresult = function(event){ 

            let transcript = '';

            for(let i = event.resultIndex;i<event.results.length;i++){
                if(event.results[i].isFinal){ // if the isFinal attribute is true then go on and save to the 
                    // transcript the result
                    // this is because the onresult event might repeat for one speak multiple times
                    // adding the same word to the transcript variable
                    transcript += event.results[i][0].transcript;
                }
                
            }



            the_output_element.innerHTML =  transcript;

            full_transcript += the_output_element.innerHTML;




        }


        /// go on and make a stop to the speech once you stop the speech
        /// take the variable that holds the whole speech 
        /// and then send that speech to openAI 
        /// to search for a product
        /// and then where are multiple choices or only one choice
        /// make the text-to-speech with the chatgpt text
        /// and after that make the speech again start
        /// and then also do the same thing with the speech talked
        /// and again make the request to the chatgpt with the results
        /// and after the results
        /// make the page go immeaditly to a particular page for example the page of that product







        recognition.onerror = function(event){
            the_output_element.innerHTML = 'Error Occoured ' + event.error;
        }


        speak.addEventListener('click',()=>{
            recognition.start();
            the_output_element.innerHTML = 'Im Listening';
        })

    }else{
        console.log('noo');
    }

    class speechControler{
        constructor(){
            const speechRecognition = window.speechRecognition || window.webkitSpeechRecognition;

            if(speechRecognition){
                this.recognition = new speechRecognition();

                this.recognition.lang = 'en-US';
                this.recognition.interimResults = true;
                this.recognition.maxAlternatives = 1;
                this.recognition.continuous = true;
            }
         
        }


        startingSpeech(){
            this.recognition.start(); // start the speech
        }

        checkingForSpeechs(){
            let the_value = ''
            this.recognition.onresult = function(event){

                let transcript = '';

                for(let i = event.resultIndex;i<event.results.length;i++){
                    if(event.results[i].isFinal){
                        transcript += event.results[i][0].transcript;
                    }
                }

                the_value += transcript;

            }

            return the_value;
        }
    }


    const the_speech_controller = new speechControler();

    the_speech_controller.startingSpeech();

    var the_value = the_speech_controller.checkingForSpeechs();

    console.log(the_value);

    function startSpeech(){
        var speechRecognition = window.speechRecognition || window.webkitSpeechRecognition;

        const speechRecognitionInstance = new speechRecognition();

        speechRecognitionInstance.start();




    }


    



    // after I save on the variable the result from all the text-speech 
    // every time i talk i will send it automaticlly to the chat api and he will generate me a product about that

    // function textToSpeech(){
    //     speak.onclick = function(){
    //         var the_content = speak.textContent;


    //         if('speechSynthesis' in window){
    //             var utterance = new SpeechSynthesisUtterance(the_content);

    //             utterance.rate = 1;
    //             utterance.pitch = 1;
    //             utterance.volume = 1;

    //             window.speechSynthesis.speak(utterance);
    //         }
    //     }
    // }

    // textToSpeech();

    
    





    






</script>
</html>