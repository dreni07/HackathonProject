<?php 


function currDate(){
    $new_instance = new DateTime();
    $formated = $new_instance->format('Y-m-d');
    return $formated;
}

$currDate = currDate();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_file'])){

    $news_title = $_POST['news_title'];
    $news_description = $_POST['news_description'];

    $count = 1;

    $the_base_file = 'news_images/';
    $the_file_name = $_FILES['image_file']['name'];
    $get_image_extension = pathinfo($the_file_name,PATHINFO_EXTENSION);
    $get_the_image_name = pathinfo(basename($the_file_name),PATHINFO_FILENAME); 
    $full_file_name = $get_the_image_name . '.' . $get_image_extension;

    $full_dir = $the_base_file . $full_file_name;

    if(!(is_dir($the_base_file))){
        mkdir($the_base_file,0777,true);
    }

    while(file_exists($full_dir)){
        $full_dir = $the_base_file . $get_the_image_name . '_' . $count . '.' . $get_image_extension;
        $count++;
    }


    if(move_uploaded_file($_FILES['image_file']['tmp_name'],$full_dir)){
        try{    
            require '../authentication/db.inc.php';

            $the_image_name = $the_file_name;

            $the_sql = 'INSERT INTO news (news_title,news_desc,news_image,news_date) VALUES (:news_title,:news_desc,:news_image,:today_date);';
            $preparing = $pdo->prepare($the_sql);

            $into_string_date = (string)$currDate;

            $preparing->bindParam(':news_title',$news_title);
            $preparing->bindParam(':news_desc',$news_description);
            $preparing->bindParam(':news_image',$the_image_name);
            $preparing->bindParam(':today_date',$into_string_date);

            $preparing->execute();

            $the_row_count = $preparing->rowCount();

            if($the_row_count){
                echo json_encode(['success'=>'added']);
            }else{
                echo json_encode(['success'=>'Not Added']);
            }


        } catch(PDOException $e){
            die('Failed Because Of ' . $e->getMessage());
        }
    }
    
    // this gets like image.jpg 

}else{
    echo json_encode(['success'=>false]);
}