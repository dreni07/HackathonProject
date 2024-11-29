<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body{
            margin:0;
            padding:0;
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
                        <div class="navigation-div adminPage active">
                            <i class='material-icons icon'>home</i>
                            <p><a href="adminPage.php">Home</a></p>
                        </div>
                    </div>
                    <div class="nav-part">
                        <div class="navigation-div AIImpacted">
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
</body>
<script>
    var all_navigations_div = document.querySelectorAll('.navigation-div');

    all_navigations_div.forEach(n=>{
        for(let i = 0;i<all_navigations_div.length;i++){
            all_navigations_div[i].classList.remove('active');
        }

        var the_window_location = window.location.href;
        
        var vl = the_window_location.split('/');

        var the_file_name = vl[vl.length - 1].split('.')[0];




        var the_classes = Array.from(n.classList);

        if(the_classes[1] == the_file_name){
            console.log(the_classes[1]);
            console.log(the_file_name);
            n.classList.add('active');
            n.style.backgroundColor = 'background-color:rgb(191, 248, 191)';
        }
    })

    
</script>
</html>