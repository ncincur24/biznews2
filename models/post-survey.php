<?php
session_start();
header('Content-Type: application/json');
$errors = [];
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $survey = $_POST['survey'];
        $user = $_SESSION['user']->user_id;
        $response = $_POST['response'];
        if($response == "undefined"){
            $errors['response'] = "Please select response";
        }
        if(count($errors) == 0){
            if(userSurvey($survey, $user)){
                if(postSurvey($response)){
                    echo json_encode(true);
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
    http_response_code(404);
}