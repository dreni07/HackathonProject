<?php

function the_pagination(){
    try{
        require '../authentication/db.inc.php';

        $limit = 8;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $off_set = ($page - 1) * $limit;

        $the_sql_query = "SELECT * FROM products LIMIT $limit OFFSET $off_set;";
        $preparing = $pdo->prepare($the_sql_query);
        $preparing->execute();


        $fetched = $preparing->fetchAll(PDO::FETCH_ASSOC);



        $sql_query = 'SELECT COUNT(*) AS total FROM products;';
        $preparing_count = $pdo->prepare($sql_query);
        $preparing_count->execute();

        $fetched = $preparing_count->fetch(PDO::FETCH_ASSOC)['Total'];
        $total_pages = ceil($fetched/$limit);

        $the_json_ready = [
            'the_data'=>$fetched,
            'total_pages'=>$total_pages
        ];

        echo json_encode($the_json_ready);

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    } 
}

the_pagination();


?>