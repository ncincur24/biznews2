<?php
session_start();
header('Content-Type: application/json');
$errors = [];
if(isset($_POST['btn'])){
    include "../connection/database.php"; 
    include "functions.php"; 
    try{
        $comment = $_POST['comment'];
        $idUser = $_POST['idUser'];
        $idNew = $_POST['idNew'];
        if(trim($comment) != ""){
            if(isset($_POST['idComment'])){
                $idComment = $_POST['idComment'];
                $postComment = postComment($comment, $idUser, $idNew, $idComment);
            }
            else{
                $postComment = postComment($comment, $idUser, $idNew, null);
            }            
            if($postComment){
                echo json_encode("You seccessfuly posted a comment");
                http_response_code(201);
            }
        }
        else{
            $errors["comment"] = "Please enter comment";
            echo json_encode($errors);
        }
    }
    catch(PDOException $exception){
        http_response_code(500);
    }
}
else{
    header("HTTP/1.0 404 Not Found");
}