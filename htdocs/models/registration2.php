<?php
    
require '../mail/PHPMailer.php';
require '../mail/SMTP.php';
require '../mail/Exception.php';
session_start();
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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
                try{
                    $mail = new PHPMailer(true);
                    $link = "http://biznewsnc4.infinityfreeapp.com/login.php?userRegister=".$conn->lastInsertId()."&unique=".(time() - 30);

                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = "true";
                    $mail->SMTPSecure = "ssl";
                    $mail->Port = "465";
                    $mail->Username = "biznewse.supp@gmail.com";
                    $mail->Password = "rajdmpbffivyieyr";
                    $mail->Subject = "Please activate your account";
                    $mail->setFrom("biznewse.supp@gmail.com", 'Admin');
                    $mail->isHTML(true);
                    $mail->Body = "Hi $name, you successfully registered, please <a href=".$link.">click here to activate your account activate</a>";
                    $mail->addAddress($email, $name);
                    if($mail->Send()){
                        if($registerUser){
                            echo json_encode("We've sent you activational link on your emal.");
                            http_response_code(201);
                        }
                    }                       
                    else{
                        $errors["email"] = "Email not sent please check your email and try again";
                        echo json_encode($errors);
                    } 
                }
                catch(Exception $ex){
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    http_response_code(500);
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