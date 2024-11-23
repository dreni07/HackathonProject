<?php
    $host = 'mysql:host=localhost;dbname=hackathon';
    $username = 'root';
    $password = '';

    try{
        $pdo = new PDO($host,$username,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
?>