<?php
session_start();
header('Content-Type: application/json');
$delete = true;
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $id = $_POST['id'];
        $img = $_POST['img'];
        if($img != 8){
            $src = "../img/".$_POST['src'];
            if(file_exists($src)){
                unlink($src);
            }
            $delete = deleteFunction("img", "img_id", $img);
        }
        if($delete){
            if(count(getComments($id)) > 0){
                $delete = deleteFunction("comments", "news_id", $id);
            }
            if($delete){
                if(deleteFunction("news", "news_id", $id)){
                    echo json_encode("Successfuly deleted new");
                    http_response_code(201);
                }
            }
        } 
    }
    catch(PDOException $exception){
        http_response_code(500);
    }
}
else{
    http_response_code(404);
}