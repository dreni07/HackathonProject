<?php

// use this function to get the last id inserted from the last 
// interaction 
function getFromTempInteractions(){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM tmp_interactions;';
        $the_preparment = $pdo->prepare($the_sql_query);

        $the_preparment->execute();

        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC);

        if($fetched_data){
            return $fetched_data;
        }
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    return [];
}

function getFiveInteractions(){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM interactions
        INNER JOIN products ON interactions.product_interacted = products.product_id
        ORDER BY interactions_id DESC LIMIT 5;'; // take the last 5 queries

        $the_preparment = $pdo->prepare($the_sql_query);
        $the_preparment->execute();

        $fetched_data = $the_preparment->fetchAll(PDO::FETCH_ASSOC); // this always gets the last 5 products added


        $the_temp_interaction = getFromTempInteractions();

        if($the_temp_interaction){
            comparing($the_temp_interaction,$fetched_data);// $the_temp_interaction in this case returns the data there

        }else{
            foreach($fetched_data as $interaction){
                $interaction_category = $interaction['product_category'];
                $interaction_id = $interaction['interactions_id'];
                addToTempTable($interaction_category,$interaction_id);
            }
        }
        // nese tmp_interactions kthen diqka domethan edhe id e fundit qaty osht per 5 ma e vogel
        // se id e fundit ne interaction table atehere 
        // dije qe jon shtu 5 interactions te rinj

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}


function comparing($temp_data,$interaction_data){
    try{
        require '../authentication/db.inc.php';

        $the_last_one = $temp_data[count($temp_data)-1]['interaction_id'];


        $the_last_at_interaction = $interaction_data[count($interaction_data)-1]['interactions_id'];

        if(($the_last_one + 4) <= $the_last_at_interaction){
            foreach($interaction_data as $data){
                $interaction_category = $data['product_category'];
                $interaction_id = $data['interactions_id'];
                addToTempTable($interaction_category,$interaction_id);
            }


        }
            
        
        

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}

function addToTempTable($category_id,$interaction_id){
    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'INSERT INTO tmp_interactions (tmp_interaction_id,interaction_id) VALUES (:tmp_interaction_id,:interaction_id);';
        $the_preparment = $pdo->prepare($the_sql_query);

        $the_preparment->bindValue(':tmp_interaction_id',$category_id);
        $the_preparment->bindValue(':interaction_id',$interaction_id);

        $the_preparment->execute();

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }
}
// KRIJO NI NEW TABLE
// QE KA ME I PERMBAJT DOMETHANE NEW 5 INTERACTIONS
// EDHE SA HER QE TE BOHEN EDHE 5 TE REJA INTERACTIONS ATEHERE
// KOM ME SHKU EDHE ME I FSHI TE VJETRAT EDHE ME I VENDOS TE REJAT

getFiveInteractions();



function getTheWinningCategory(){
    $most_frequented = [];
    try{
        require '../authentication/db.inc.php';
        $the_query = 'SELECT * FROM tmp_interactions;';
        $the_prepare = $pdo->prepare($the_query);
        $the_prepare->execute();

        $all_the_data = $the_prepare->fetchAll(PDO::FETCH_ASSOC);

        foreach($all_the_data as $the_data){
            $the_category = $the_data['tmp_interaction_id'];
            $into_string = (string)$the_category;
            if(array_key_exists($into_string,$most_frequented)){
                $most_frequented[$into_string] += 1;
            }else{
                $most_frequented[$into_string] = 1;
            }
        }

    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }


    return arsort($most_frequented);
}



function getTheDataAboutCategory(){
    $most_frequented = getTheWinningCategory();
    try{
        require '../authentication/db.inc.php';

        $sql_query = 'SELECT * FROM categories WHERE category_id = :category_id;';
        $preparing = $pdo->prepare($sql_query);
        $preparing->bindParam(':category_id',$most_frequented);
        $preparing->execute();

        $fetched_data = $preparing->fetch(PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }

    if($fetched_data){
        return $fetched_data;
    }

    return [];
}

$the_category_data = getTheDataAboutCategory();
$the_interactions = getFromTempInteractions();
$index = count($the_interactions) - 1;

if($the_category_data){
    echo json_encode(['success'=>true,'category_name'=>$the_category_data['category_name'],'last_inserted_id'=>$the_interactions[$index]['tmp_product_id'],'category_id'=>$the_category_data['category_id']]);
}else{
    echo json_encode(['success'=>'Something Went Wrong']);
}






?>