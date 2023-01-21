<?php
session_start();
$errors = [];
$wrong = 0;
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $question = $_POST['question'];
        $responses = $_POST['respones']; 
        if(count($responses) < 2){
            $errors["responses"] = "Please enter at least 2 responses";
        }
        if(count($errors) == 0){
            if(addSurvey($question)){
                $id = $conn->lastInsertId();
                foreach($responses as $r){
                    if(!addSurveyResponses($r, $id)){
                        $wrong++;
                    }
                }
                if($wrong == 0){
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