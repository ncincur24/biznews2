<?php
session_start();
header('Content-Type: application/json');
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    $id = $_POST['id'];
    $status = $_POST['status'];
    try{
        if(updateTable($id, "survey", "active", $status, "survey_id")){
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