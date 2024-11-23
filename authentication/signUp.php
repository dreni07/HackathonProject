<?php

function signUp(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $the_username = $_POST['username'];
        $the_email = $_POST['email'];
        $the_password = $_POST['password'];

        $hashed_password = password_hash($the_password,PASSWORD_DEFAULT);


        try{
            require 'db.inc.php';

            $the_sql = 'INSERT INTO users (username,email,password) VALUES (:username,:email,:password);';
            $the_preparment = $pdo->prepare($the_sql);

            $the_preparment->bindParam(':username',$the_username);
            $the_preparment->bindParam(':email',$the_email);
            $the_preparment->bindParam(':password',$hashed_password);

            $the_preparment->execute();

            $the_row_count = $the_preparment->rowCount();


            if($the_row_count){
                return true;
            }
        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }

        return;
    }
}
$signing_up = signUp();

if($signing_up){
    echo json_encode(['success'=>true]);
}else{
    echo json_encode(['success'=>false]);
}
?>

