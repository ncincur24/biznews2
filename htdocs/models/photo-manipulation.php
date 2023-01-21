<?php

session_start();
include "../connection/database.php"; 
include "functions.php"; 
if(isset($_POST['deletePhoto'])){
    $src = $_POST['imgSrc'];
    $user = $_SESSION['user'];
    if($user->profile_img_id != 1){
        $src = "../img/".$src;
        if(file_exists($src)){
            unlink($src);
        }
        if(updateProfileImg($user->user_id, 1)){
            if(deleteFunction("profile_img", "profile_img_id", $user->profile_img_id)){
                header("Location: sign-out.php?id=1");
            }
        }     
    }
    else{
        header("Location: ../user.php");
    }
}
else if(isset($_FILES['changePhoto'])){
    $file = $_FILES['changePhoto'];

    $name = $file['name'];
    $tempName = $file['tmp_name'];
    $size = $file['size'];
    $type = $file['type'];
    $errors = $file['error'];

    $countErr = 0;
    $allopwedType = ["image/jpg", "image/jpeg", "image/png"];
    header("Location: ../user.php");

    if(!in_array($type, $allopwedType)){
        $countErr++;
        $errors++;
        $_SESSION['profileTypeError'] = "Allowed types are jpg, jpeg or png";
    }
    if($countErr == 0){
        $newName = time()."_".$name;
        $src = "../img/".$newName;
        $alt = time()."-user".$_SESSION['user']->user_id."_profilepicture";
        if(move_uploaded_file($tempName, $src)){    
            if(addProfilePicture($newName, $src)){
                $img = $conn->lastInsertId();
                if(updateData($_SESSION['user']->user_id, "profile_img_id", $img)){
                    header("Location: sign-out.php?id=1");
                }           
            }
        }
    }  
    else{
        header("Location: ../user.php");
    }   
}
else{
    http_response_code(404);
}
