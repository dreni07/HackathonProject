<?php
namespace weeklyProduct;

use DateTime;
use PDO;
use PDOException;
use Exception;

function dateBeforeOneWeek(){
    $date = new DateTime();
    $date->modify('-1 week');
    $the_date = $date->format('Y-m-d');
    return $the_date;
}
function getMostWeeklyProducts(){
    $date_before_one_week = dateBeforeOneWeek();
    $order_completion = 'ACCEPTED';

    try{
        require '../authentication/db.inc.php';

        $the_sql_query = 'SELECT * FROM orders INNER JOIN products ON orders.id_product = products.product_id WHERE orders.order_completion = :order_completion AND orders.order_date > :order_date;';
        $preparing = $pdo->prepare($the_sql_query);
        $preparing->bindParam(':order_completion',$order_completion);
        $preparing->bindParam(':order_date',$date_before_one_week);

        $preparing->execute();

        $fetched = $preparing->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e){
        die('Failed Because Of ' . $e->getMessage());
    }


    if($fetched){
        return ['success'=>'True','data'=>$fetched];
    }else{
        return [];
    }
    // first implement an function to get all the products ordered the last week
    // take the date of the product and compare with the date before one week
    // and if its bigger then select that product that was ordered that week
}


function MostProductOrdered(){
    $the_assoc_data = [];
    try{
        require '../authentication/db.inc.php';
        $the_function = getMostWeeklyProducts();
        if($the_function['success'] == 'True'){
            $the_data = $the_function['data'];

            for($j = 0;$j<count($the_data);$j++){
                if(array_key_exists($the_data[$j]['product_name'],$the_assoc_data)){
                    $the_assoc_data[$the_data[$j]['product_name']] += 1;
                }else{
                    $the_assoc_data[$the_data[$j]['product_name']] = 1;
                }
            }
        }else{
            return;
        }
    } catch(Exception $e){
        die('Failed Because Of '.$e->getMessage());
    }

    // sort the assoc array in descending order
    arsort($the_assoc_data);
    // get the array keys
    $keys = array_keys($the_assoc_data);
    $top_5 = [];
    // get only the first 5 which will be the most products ordered
    // because we did sort the assoc array in descending order
    for($i = 0;$i<5;$i++){
        // key
        $key = $keys[$i];
        //value
        $value = $the_assoc_data[$key];
        // add to assoc arr
        $top_5[$key] = $value;
    }


    return $top_5;
}


// now that I have the most products ordered this week
// what I can Do Is Compare The Two Lists 
// and in a function return the top 5 products with all the data included like description category etc etc

function getFullData(){
    $full_data = [];
    $only_names = [];
    try{
        $the_weekly_products = getMostWeeklyProducts();
        if($the_weekly_products){
            $the_all_data = getMostWeeklyProducts()['data'] ? getMostWeeklyProducts() : [];
            $the_most_products_ordered = MostProductOrdered();
            for($i = 0;$i<count($the_all_data);$i++){
                $contains = False;
                $the_current_data = $the_all_data[$i];
                foreach($the_most_products_ordered as $key=>$value){
                    if($key == $the_current_data['product_name'] && !(in_array($key,$only_names))){
                        $contains = True;
                        break;
                    }
                }
    
                if($contains){
                    array_push($full_data,$the_current_data);
                    array_push($only_names,$the_current_data['product_name']);
                }
            }
        }
       
       
    } catch(Exception $e){
        die('Error Raised ' . $e->getMessage());
    }


    return $full_data;
}
$the_full_data = getFullData();
header('Content-Type:application/json');
echo json_encode(['success'=>'True','data'=>$the_full_data]);

?>