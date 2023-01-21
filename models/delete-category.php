<?php
session_start();
$errors = [];
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $id = $_POST['id']; 

        if(countNews($id)->number > 0){
            $errors["news"] = "You can't delete this category";
        }
        if(count($errors) == 0){
            if(deleteFunction("category", "category_id", $id)){
                echo json_encode(true);
                http_response_code(201);
            }
        }    
        else echo json_encode($errors);   
        
    }
    catch(PDOException $exception){
        http_response_code(500);
    }
}
else{
    http_response_code(404);
}