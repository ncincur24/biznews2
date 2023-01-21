<?php
    session_start();
    header("Content-type: application/json");
    $errors = [];
    if(isset($_POST['btn'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $id = $_POST['id'];
            $password = $_POST['password'];

            if(checkErrors("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/", $password)){
                $errors["password"] = "Password length has to be at least 6, and it has to have at least one number and no special characters";
            }
            if(count($errors) == 0){
                if(updateData($id, "password",md5($password))){
                    echo json_encode("Password changed");
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
