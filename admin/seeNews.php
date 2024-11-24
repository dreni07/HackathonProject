<?php

function currDate(){
    $current_date = new DateTime();
    $the_formated = $current_date->format('Y-m-d');
    return $the_formated;
}



if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(strpos($_SERVER['HTTP_REFERER'],'adminHome.php')){
        $the_date = null;
        seeNews($the_date);
    }else{
        $the_date = currDate();
        seeNews($the_date);
    }
}


function seeNews($the_date){
    try{
        require '../authentication/db.inc.php';

        $first_sql = 'SELECT * FROM news WHERE news_date >= :old_date;';
        $the_sql = 'SELECT * FROM news;';

        $final_query = $the_date ? $first_sql : $the_sql;

        $preparing = $pdo->prepare($final_query);
        
        if($the_date){
            $preparing->bindParam(':old_date',$the_date);
        }

        $preparing->execute();

        $fetched_data = $preparing->fetchAll(PDO::FETCH_ASSOC);

        if($fetched_data){
            echo json_encode(['success'=>true,'data'=>$fetched_data]);
            return;
        }

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    echo json_encode(['success'=>false]);
}
?>