<?php

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
    function getCurrentDate(){
        $the_data = date('y-m-d');
        return $the_data;
    }

    $the_current_date = getCurrentDate();
    $into_string = (string)$the_current_date;
    $the_month  = explode('-',$into_string);
    $get_the_month_value = $dict_with_months[$the_month[1]];

    $full_day = "$the_month[2] $get_the_month_value/$the_month[0]";
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
            display:flex;
            overflow:hidden;
            
        }

        .container{
            height:100vh;
            /* width:100%; */
            width:17%;
            display:flex;
        }
        .nav-bar{
            
            height:100vh;
            width:100%;
            background-color:white;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2), 0 4px 18px rgba(0, 0, 0, 0.19);
            transform:scale(1.01);

        }

        .nav-bar .profile-admin{
            width:100%;
            height:50px;
            text-align:center;
        }

        .nav-bar .profile-admin p{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            font-size:23px;
        }
        .nav-bar .profile-admin span{
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

        a{
            text-decoration:none;
            color:#333;
        }

        .container-page{
            display:grid;
            grid-template-rows:1fr 2fr;
            width:100%;
            height:100vh;
        }

        .container-page  .container-page-nav{
            display:flex;
            justify-content:space-between;
        }

        .container-page  .container-page-nav .searchbar{
            display:flex;
            align-items:center;
            position:relative;
        }

        .searchbar img{
            cursor:pointer;
            padding-bottom:50px;
            padding-right:50px;
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
            top:50%;
            left:50%;
            transform:translateX(-100%);
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
            transform:translate(50%,-100%);
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

        .container-page .container-page-nav .title h1{
            color:#333;
            font-family:'Athiti';
            font-weight:1000;
            height:fit-content;
            padding-left:30px;
        }

        .container-page  .container-page-nav .title p{
            color:#333;
            opacity:0.8;
            font-weight:500;
            font-size:15px;
            font-family:'Anaheim';
            padding-left:30px;
        }

        .container-page-charts{
            display:grid;
            grid-template-rows:2fr 1fr;
        }
        .container-page-charts .charts{
            display:grid;
            grid-template-columns:repeat(2,1fr);
        }

        #my_canvas{
            height:200px;
            width:250px;
            padding-left:20px;
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
                        <div class="navigation-div adminPage">
                            <i class='material-icons icon'>home</i>
                            <p><a href="adminPage.php">Home</a></p>
                        </div>
                    </div>
                    <div class="nav-part">
                        <div class="navigation-div AIImpacted active">
                            <i class='material-icons icon'>add</i>
                            <p><a href="AIImpacted.php">AI Analys</a></p>
                        </div>
                    </div>
                    <div class="nav-part">
                        <div class="navigation-div productsByAI ">
                            <i class='material-icons icon'>pending</i>
                            <p><a href="productsByAI.php">AI Products</a></p>
                        </div>
                    </div>
                    
                        
                </div>
        </div>

    </div>

    <div class="container-page">
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
               
            </div>
        </div>
        <div class="container-page-charts">
            <div class="charts">
                <div class="canvas-first-part">
                    <canvas id='my_canvas' width='200' height='100'>

                    </canvas>
                </div>
                
                <div class="canvas-second-part">
                    <canvas id='my_canvas_2'></canvas>

                </div>
            </div>
            <div class="another-charts">

            </div>

        </div>
    </div>
    

    <!-- <canvas id='my_canvas_2'></canvas>
    <input type="file" id='inputiFile' accept='.csv'>
    <button>upload</button> -->

</body>
<script>
    const the_url = 'AIAnalys.php';

    async function getAIData(){
        try{    

            const response = await fetch(the_url);
            const answer = await response.json();

            return answer;
        } catch(err){
            console.error(err);
        }
    }

    function makingCharts(){
        var the_AI_Data = getAIData();

        the_AI_Data.then(answer=>{
            var my_canvas = document.getElementById('my_canvas').getContext('2d');

            var numberBefore = answer.numberOfOrdersBefore;
            var numberAfter = answer.numberOfOrdersAfter;

            const the_chart = new Chart(my_canvas,{
                type:'bar',
                data:{
                    labels:['Order Statistics'],
                    datasets:[
                        {
                            label:'Number Of Orders Before AI',
                            data:[numberBefore],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Color for the bars of Statistic 1
                            borderColor: 'rgba(255, 99, 132, 1)', // Border color for Statistic 1
                            borderWidth: 1 // Border width
                        },
                        {
                            label:'Number Of Orders After AI',
                            data:[numberAfter],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color for the bars of Statistic 2
                            borderColor: 'rgba(54, 162, 235, 1)', // Border color for Statistic 2
                            borderWidth: 1 // Border width

                        }
                ]
                },
                options:{
                    scales:{
                        y:{
                            beginAtZero:true
                        }
                    }
                }
            })
        })

    }

    makingCharts();
    

    async function chatAI(the_data){
    
        console.log(the_data);
        const url = 'https://chatgpt-gpt5.p.rapidapi.com/ask';
        const options = {
            method: 'POST',
            headers: {
                'x-rapidapi-key': 'e2b949a7cemsh503ba2581247ed5p1e6919jsnd40034f5a671',
                'x-rapidapi-host': 'chatgpt-gpt5.p.rapidapi.com',
                'Content-Type': 'application/json'
            },
            body:JSON.stringify(
                {
                    query: `BASED ON THOSE DATA ${JSON.stringify(the_data)} PREDICT THE FUTURE SALES and provide for me a dataset like this with the predictions please also send the dataset in the same format! ALSO PLEASE SEND ME JUST THE DATASET WITHOUT EXTRA TALK OR INFO PLEASE.`,

                }
            ) 
        };

        try {
            const response = await fetch(url, options);
            const result = await response.json();
            return result;
            console.log(result);
        } catch (error) {
            console.error(error);
        }

    
}

// every time a new order is set
// just go on and make a request 
// and then save those data in the local storage




async function get_the_data(){
    try{
        const response = await fetch('AIAnalys.php?dataset=hello');
        const answer = await response.json();
        
        var the_data = answer.data;

        chatAI(the_data).then(response=>{
            console.log(response);
            var the_response = JSON.parse(response.response);

            var the_item = localStorage.getItem('dataAboutOrders') ? localStorage.getItem('dataAboutOrders') : null;
            if(the_item){
                localStorage.removeItem('dataAboutOrders');
                var the_new_data = JSON.stringify(the_response);
                localStorage.setItem('dataAboutOrders',the_new_data);
            }else{
                localStorage.setItem('dataAboutOrders',JSON.stringify(the_response));
            }

            var getting_the_data = localStorage.getItem('dataAboutOrders');

            var into_js_data = JSON.parse(getting_the_data);
            console.log(into_js_data);
            predictionChart(into_js_data);
        });
    } catch(err){
        console.error(err);
    }
}

// get_the_data();


var data_chart = ''
function predictionChart(the_chart){
    var my_canvas_2 = document.getElementById('my_canvas_2').getContext('2d');

    var the_dates = [];
    var the_orders = [];

    if(the_chart){
        
        for(let i = 0;i<the_chart.length;i++){
            the_dates.push(the_chart[i].date);
            the_orders.push(parseInt(the_chart[i].orders));
        }


        console.log(the_chart);

        console.log(the_dates);
        console.log(the_orders);

        
        if(data_chart){
            data_chart.destroy();
        }

        data_chart = new Chart(my_canvas_2,{
            type:'line',
            data:{
                labels:the_dates,
                datasets:[{
                    label:'Prediction',
                    data:the_orders,
                    borderColor: 'blue',
                    fill: false,
                    borderColor:'#a4b4f7',
                    tension:0.1,
                    // lineTension:0.2,
                    pointRadius:4,
                    pointBackgroundColor:'#F7E7A4',
                    pointHoverRadius:7,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid:{
                            borderColor:'#00000',
                            borderWidth:1,
                            color:'rgb(225,225,225)',
                        }
                    },
                    x:{
                        beginAtZero:true,
                        grid:{
                            borderColor:'#333',
                            borderWidth:7,
                            color:'rgb(225,225,225)',
                        }
                    }
                },
                
                
            }
        })
    }

}

var the_data = localStorage.getItem('dataAboutOrders') ? localStorage.getItem('dataAboutOrders') : [];
var parsed_data = JSON.parse(the_data);
predictionChart(parsed_data);


async function isThereANewOrder(){
    try{
        const response = await fetch('checkForNewOrder.php');

        if(!response.ok){
            throw new Error('Something Went Wrong!');
        }

        const answer = await response.json();

        if(answer.success == true){
            get_the_data(); // if there is a new order update the stats;
        }
        console.log(answer);
    } catch(err){
        console.error(err);
    }
    
}

isThereANewOrder();


  
   



    
</script>
</html>