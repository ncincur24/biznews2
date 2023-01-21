<?php

    require "../mail/PHPMailer.php";
    require "../mail/SMTP.php";
    require "../mail/Exception.php";
    session_start();
    header("Content-type: application/json");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
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
                    if(lockAccount($email, 5) > 3 && getIdUser($email)->active == 0){
                        try{
                            $link = "http://biznewsnc6.infinityfreeapp.com/index.php?page=login&lockAcc=".getIdUser($email)->user_id."&lock=".md5("lock");
                            $mail = new PHPMailer(true);

                            //Server settings                    //Enable verbose debug output
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host = "smtp.gmail.com";                 //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'biznewse.supp@gmail.com';                     //SMTP username
                            $mail->Password   = 'rkzmmrzgydetqgqs';                               //SMTP password
                            $mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
                            $mail->Port = 465; 
                            $mail->isHTML(true);                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                            //Recipients
                            $mail->setFrom('biznewse.supp@gmail.com', 'Admin');
                            $mail->addAddress($email, $name); 
                            
                            $mail->Subject = 'Someone tried to log in';
                            $mail->Body = "It looks like someone wanted to login on your account, so we locked it. Click here to unlock it <a href=".$link.">Here</a>";

                            if($mail->send()){
                                updateTable($email, "users", "active", 1, "email");
                                $errors["passLog"] = "You had more than 3 wrong inputs so we blocked your account, you can activate it by clicking on link that we sent you on email";
                                http_response_code(201);
                            }
                        } 
                        catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {".$mail->ErrorInfo."}";
                            http_response_code(500);
                        }
                    }
                    if(checkActive($email)->active == 1){
                        $errors["email"] = "This account is temporarly banned";
                        errorLogFile($email, "Account banned");
                    }
                    else if(!$pass){
                        $errors["passLog"] = "Incorrect password";
                        errorLogFile($email, "Incorrect password");
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
                enterLogFile($user->email, $user->role);
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
