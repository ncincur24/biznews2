<?php
session_start();
header('Content-Type: application/json');
$errors = [];
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $cat = $_POST['cat'];
        $gender = $_POST['gender'];
        if($cat == 0){
            $errors['category'] = "Please select category";
        }
        if($gender == ""){
            $errors['gender'] = "Please select gender";
        }
        if(count($errors) == 0){
            changeStatus($_SESSION['user']->user_id, 1, "survey");
            if(postSurvey($cat, $gender)){
                echo json_encode("Thank you");
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