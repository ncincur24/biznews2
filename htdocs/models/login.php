<?php
    session_start();
    header("Content-type: application/json");
    $errors = [];
    if(isset($_POST['btnl'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors["email"] = "Please enter your email ex. email@gmail.com";
                if(checkErrors("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/", $password)){
                    $errors["passLog"] = "Password length has to be at least 6, and it has to have at least one number and no special characters";
                }
            }
            else{
                $exist = checkEmail($email);
                if($exist){  
                    $pass = checkPassword($email, md5($password));
                    if(!$pass){
                        $errors["passLog"] = "Incorrect password";
                    }
                    else if(checkActive($email, md5($password))->active == 1){
                        $errors["email"] = "This account is temporarly banned";
                    }
                }
                else{
                    $errors["email"] = "User with this email, doesn't exist";
                    if(checkErrors("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/", $password)){
                        $errors["passLog"] = "Password length has to be at least 6, and it has to have at least one number and no special characters";
                    }
                }
            }
            if(count($errors) == 0){
                $user = login($email, md5($password));
                if($user){
                    $_SESSION['user'] = $user;
                    echo json_encode("Welcome ".$user->name);
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
