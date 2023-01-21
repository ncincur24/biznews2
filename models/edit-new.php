<?php
    session_start();
    header("Content-type: application/json");
    $errors = [];
    $exitst = false;
    if(isset($_POST['btn'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $categories = selectAll("category");
            $id = $_POST['idNew'];
            $category = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            if(checkErrors("/^([\w\.\-\s\!\?\,\(\)\"\'\:\;\@]){10,80}$/", $title)){
                $errors["title"] = "Title must have between 10 and 80 characters";
            }
            if(checkErrors("/^([\w\.\-\s\!\?\,\(\)\"\'\:\;\@]){30,}$/", $content)){
                $errors["content"] = "Content should have at least 30 characters";
            }
            if(checkErrors("/^[1-9]\d*$/", $category)){
                $errors["category"] = "You're really tiring and stupid.";
            }
            else{
                foreach($categories as $c){
                    if($category == $c->category_id){
                        $exitst = true;
                    }
                }
                if(!$exitst){
                    $errors["category"] = "As I said, your attempt won't work";
                }
            }
            if(count($errors) == 0){
                if(updateNew($id, $title, $content, $category)){
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
