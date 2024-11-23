<?php
function logIn(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $the_username = $_POST['username'];
        $the_password = $_POST['password'];
        try{
            require 'sessions.inc.php';
            require 'db.inc.php';
            $the_sql = 'SELECT * FROM users WHERE username = :username;';
            $preparing = $pdo->prepare($the_sql);
            $preparing->bindParam(':username',$the_username);
            $preparing->execute();

            $fetched_data = $preparing->fetch(PDO::FETCH_ASSOC);


            if($fetched_data){
                $the_password_fetched = $fetched_data['password'];

                $verifying = password_verify($the_password,$the_password_fetched);

                if($verifying){
                    $_SESSION['userId'] = $fetched_data['id'];
                    // header('Location:../e-comm/home.php');
                    return ['success'=>'Logged In'];
                }else{
                    return ['success'=>'Incorrect Password'];
                }
            }else{
                return ['success'=>false];
            }


        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }
    
} 

$the_log_in_value = logIn();

if($the_log_in_value){
    $the_returned = $the_log_in_value['success'];

    if($the_returned == 'Incorrect Password'){
        echo json_encode(['success'=>'Incorrect Password']);
    }elseif($the_returned == 'Logged In') {
        echo json_encode(['success'=>'Logged In']);
        // header('Location:../e-comm/home.php');
    }else{
        echo json_encode(['success'=>'No User Like That']);
    }
}

?>