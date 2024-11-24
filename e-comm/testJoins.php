<?php

// function crossJoin(){
//     try{
//         require '../authentication/db.inc.php';

//         $sql_query = 'SELECT * FROM userdata CROSS JOIN likedproducts;';
//         $preparing = $pdo->prepare($sql_query);
//         $preparing->execute();

//         $fetched = $preparing->fetchAll(PDO::FETCH_ASSOC);

//         print_r($fetched);
//     } catch(PDOException $e){
//         die('Failed ' . $e->getMessage());
//     }
// }

// crossJoin();

?>