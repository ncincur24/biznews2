<?php
session_start();
header('Content-Type: application/json');
$errors = [];
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $name = $_POST['name'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if(checkErrors("/^[A-Z][a-z]{2,15}$/", $name)){
            $errors["name"] = "Plese enter your name ex. David";
        }
        if(checkErrors("/^[A-Z][a-z]{2,15}(\s([A-Z][a-z]{2,15})){0,3}$/", $lastName)){
            $errors["lastName"] = "Plese enter your last name name ex. James";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors["email"] = "Please enter your email ex. email@gmail.com";
        }
        else{
            $exist = checkEmail($email);
            if($exist){
                $errors["email"] = "This email is already in use, please enter another email ";
            }
        }
        if(checkErrors("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/", $password)){
            $errors["password"] = "Password length has to be at least 6, and it has to have at least one number and no special characters";
        }
        if(count($errors) == 0){        
            $registerUser = registration($name, $lastName, $email, md5($password));
            if($registerUser){
                $user = login($email, md5($password));
                if($user){
                    $_SESSION['user'] = $user;
                    echo json_encode("Welcome ".$user->name);
                    http_response_code(201);
                }
            }
        }
        else echo json_encode($errors);
    }
    catch(PDOException $exception){
        http_response_code(500);
    }
}
else{
    header("HTTP/1.0 404 Not Found");
}