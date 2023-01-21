<?php
    session_start();
    header("Content-type: application/json");
    $errors = [];
    if(isset($_POST['btn'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $id = $_POST['id'];
            $edit = $_POST['edit'];

            if(checkErrors("/^([A-Z][a-z]{2,15}){1,5}(\s[A-Z]{0,2}[a-z]{2,15}){0,4}$/", $edit)){
                $errors["edit"] = "Category must start with capital and have no nubers";
            }
            if(checkCat($edit)){
                $errors["edit"] = "Category with this name already exists";
            }
            if(count($errors) == 0){
                if(updateTable($id, "category", "name", $edit, "category_id")){
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
