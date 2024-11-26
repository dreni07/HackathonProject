<?php 

require 'sessions.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $_SESSION['adminId'] = null;
    $_SESSION['admin_username'] = null;

    header('Location:logIn.html');
}

?>