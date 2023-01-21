<?php
session_start();
header('Content-Type: application/json');
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $id = $_POST['id'];
        if(deleteFunction("messages", "message_id", $id)){
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