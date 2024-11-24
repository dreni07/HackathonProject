<?php

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    require 'sessions.inc.php';

    $_SESSION['userId'] = null;

    header('Location:logIn.html');
}

?>