<?php
session_start();
header('Content-Type: application/json');
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $id = $_POST['id'];
        if(count(getRepyComments($id)) > 0){
            deleteComment($id, true);
        }
        if(deleteComment($id, false)){
            echo json_encode(true);
            http_response_code(201);
        }
    }
    catch(PDOException $exception){
        http_response_code(500);
    }
}
else{
    http_response_code(404);
}