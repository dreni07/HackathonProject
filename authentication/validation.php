<?php

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        checkIfUserLogged();
    }
    
    function checkIfUserLogged(){
        require 'sessions.inc.php';

        if(isset($_SESSION['userId'])){
            echo json_encode(['success'=>true]);
            return;
        }else{
            echo json_encode(['success'=>false]);
            return;
        }

    }

?>