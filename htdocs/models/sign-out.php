<?php
    session_start();
    if(isset($_GET['id'])){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            header("Location: ../index.php");
        }
    }    
    else{
        header("HTTP/1.0 404 Not Found");
    }
?>