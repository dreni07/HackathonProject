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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='../css/logIn.css?v=1.0'>
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

    </style>
</head>
<body>
    <div class="upper-nav">
            <div class="phone-part">
                <p><img src="../website_images/phone-logo.png" height='10' width='10'>045441654</p>
            </div>
            <div class="free-part">
                <span>Get 50% Off On Selected Items</span>
                <a href="">Shop Now</a>
            </div>
            <div class="location-part">
                <div class="language">
                    <p id='full-total'>History Spent:</p>
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
                        <span>Cart</span>
                    </div>
                    <div class="acc">
                        <img src="../website_images/log-out.png" height='20' width='20' style='position:relative; top:5px;'>
                        <span><a href="../authentication/logOut.php">Log Out</a></span>
                    </div>
                </div>
            </div>
        </div>



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
                            <img src="../product_images/hand-cream.jpg" width='220' height='140' style='border-radius:4px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 4px 8px rgba(0, 0, 0, 0.19);' id='image'>
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

</body>
</html>