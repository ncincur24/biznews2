<?php
    session_start();
    header("Content-type: application/json");
    $errors = [];
    if(isset($_POST['btn'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $name = $_POST['name'];    
            $email = $_POST['email'];    
            $message = $_POST['message'];    

            if(checkErrors("/^[A-Z][a-z]{2,15}$/", $name)){
                $errors["name"] = "Plese enter your name ex. David James";
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors["email"] = "Please enter your email ex. email@gmail.com";
            }
            if(checkErrors("/^([\w\.\-\s]{10,150})+$/", $message)){
                $errors["message"] = "Plese enter your last name name ex. James";
            }
            if(count($errors) == 0){        
               if(sendMessage($name, $email, $message)){
                    echo json_encode("Your message has been sent succesfuly");
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
