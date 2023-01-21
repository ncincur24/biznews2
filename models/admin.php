<?php
session_start();
header('Content-Type: application/json');
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['dataValue'];
    try{
        if(updateData($id, addslashes($column), $value)){
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