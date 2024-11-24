<?php
    require './sessions.inc.php';

    if(isset($_SESSION['userId'])){
        header('Location:../e-comm/home.php');
    }



    if(isset($_SESSION['adminId'])){
        header('Location:../admin/adminPage.php');
    }
    

    function logInAsAdmin(){
        // nese nuk je logged in as user or as an admin
        if(empty($_SESSION['userId']) && empty($_SESSION['adminId'])){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $the_username = $_POST['username'];
                $the_password = $_POST['password'];
                try{
                    require '../authentication/db.inc.php';
                    $the_sql_query = 'SELECT * FROM admintable WHERE admin_username = :admin_username AND admin_password = :admin_password;';
                    $prepare = $pdo->prepare($the_sql_query);
                    $prepare->bindParam(':admin_username',$the_username);
                    $prepare->bindParam(':admin_password',$the_password);
                    $prepare->execute();
                    $fetched = $prepare->fetch(PDO::FETCH_ASSOC);
                } catch(PDOException $e){
                    die('Failed Logging ' . $e->getMessage());
                }

                if($fetched){
                    $_SESSION['adminId'] = $fetched['admin_id'];
                    $_SESSION['admin_username'] = $fetched['admin_username'];
                    return true;
                }else{
                    return false;
                }
            }
           
        }
        
    }

    $the_returned_value = logInAsAdmin();

    
    if($the_returned_value){
        echo json_encode(['success'=>$the_returned_value]);
    }else{
        echo json_encode(['success'=>$the_returned_value]);
    }



?>