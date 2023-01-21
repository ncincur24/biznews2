<?php
session_start();
$errors = [];
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $nameCat = $_POST['nameCat']; 

        if(checkErrors("/^([A-Z][a-z]{2,15}){1,5}(\s[A-Z]{0,2}[a-z]{2,15}){0,4}$/", $nameCat)){
            $errors["nameCat"] = "Category must start with capital and have no nubers";
        }
        if(checkCat($nameCat)){
            $errors["nameCat"] = "Category with this name already exists";
        }
        if(count($errors) == 0){
            if(addCategory($nameCat)){
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