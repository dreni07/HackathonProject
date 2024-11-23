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
                    var into_an_array = Array.from(answer.data);
                    var getCookieData = JSON.parse(decodeURIComponent(getCookie('products_clicked')));
                    into_an_array.forEach(a=>{
                        creatingUI(a,getCookieData);
                    })
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
            console.log(response);
            if(!response.ok){
                throw new Error('Error During The Proccess');
            }

            const answer = await response.json();

            console.log(answer);



            if(answer.success){
                var answer_data = answer.data;
                console.log(answer_data);
                answer_data.forEach((a,index)=>{
                    const the_cookie_data = getCookie('products_clicked') ? JSON.parse(decodeURIComponent(getCookie('products_clicked'))) : [];
                    creatingUI(a,the_cookie_data);
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
    let the_value = the_cookie.split(`; ${cookieName}=`);
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
    product_price.textContent = a.product_price.toString() + `$`;
    image.src = `../product_images/${a.product_image}`;


    div_product.className = 'div-product';
    div_product.dataset.id = a.product_id;

    name_price.append(product_name);
    name_price.append(product_price);
    image_part.append(image);

    div_product.append(name_price);
    div_product.append(image_part);

    settingCookie();

    if(cookieData.includes(a.product_id.toString())){
        div_product.classList.add('product-class-added');
    }

    

    if(!(the_array_with_data.includes(a.product_id))){
        search_bar_results.append(div_product);
    }
}   



function cookieLifeTime(){
    let the_date = new Date();
    the_date.setDate(the_date.getDate() + 7);
    return the_date.toUTCString();
}


if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $the_product_name = $_GET['product_name'] ? $_GET['product_name'] : null;
        if($the_product_name){
            searchProducts($the_product_name);
        }
    }

    function searchProducts($product){
        try{    
            require '../authentication/db.inc.php';
            $sql_query = "SELECT * FROM products WHERE product_name LIKE '%$product%' AND product_in_stock > 0;";
            $preparing = $pdo->prepare($sql_query);
            $preparing->execute();

            $fetch_data = $preparing->fetchAll(PDO::FETCH_ASSOC);

            if($fetch_data){
                echo json_encode(['success'=>True,'data'=>$fetch_data]);
            }else{
                echo json_encode(['success'=>False]);
            }
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }