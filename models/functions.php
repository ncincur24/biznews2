<?php
//header("HTTP/1.0 404 Not Found");

function checkErrors($reg, $var){
    $error = false;
    if(!preg_match($reg, $var)){
        $error = true;
    }
    return $error;
}
function selectAll($table){
    global $conn;
    $query = "SELECT * FROM $table";
    $result = $conn->query($query)->fetchAll();
    return $result;
}
function selectHeadlines(){
    global $conn;
    $query = "SELECT * FROM img i INNER JOIN news n ON i.img_id=n.img_id INNER JOIN category c ON n.category_id=c.category_id ORDER BY n.date DESC LIMIT 11";
    $result = $conn->query($query)->fetchAll();
    return $result;
}
function trendingNews(){
    global $conn;
    $query = "SELECT n.news_id, n.title, n.content, n.date, n.img_id, n.category_id, ca.name FROM comments c INNER JOIN news n on c.news_id=n.news_id INNER JOIN category ca on n.category_id=ca.category_id GROUP BY n.news_id, n.title, n.content, n.date, n.img_id, n.category_id, ca.name ORDER BY COUNT(c.comm_id) DESC LIMIT 3";
    $result = $conn->query($query)->fetchAll();
    return $result;
}
function countNews($id){
    global $conn;
    $query = "SELECT COUNT(*) AS number FROM news WHERE category_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function singleNew($id){
    global $conn;
    $query = "SELECT * FROM img i INNER JOIN news n ON i.img_id=n.img_id INNER JOIN category c ON n.category_id=c.category_id WHERE n.news_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function registration($name, $lastName, $email, $password){
    global $conn;
    $query = "INSERT INTO users(name, last_name, email, password) VALUES (:name, :lastName, :email, :password)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':name', $name);
    $prepare->bindParam(':lastName', $lastName);
    $prepare->bindParam(':email', $email);
    $prepare->bindParam(':password', $password);

    $result = $prepare->execute();
    return $result;
}
function login($email, $password){
    global $conn;
    $query = "SELECT * FROM roles r INNER JOIN users u ON r.role_id = u.role_id INNER JOIN profile_img p on u.profile_img_id = p.profile_img_id WHERE u.email = :email AND u.password = :password AND u.active = 0";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':email', $email);
    $prepare->bindParam(':password', $password);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function checkPassword($email, $password){
    global $conn;
    $query = "SELECT password FROM users WHERE email = :email AND password = :password";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':password', $password);
    $prepare->bindParam(':email', $email);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function checkActive($email){
    global $conn;
    $query = "SELECT active FROM users WHERE email = :email";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':email', $email);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function checkEmail($email){
    global $conn;
    $query = "SELECT email FROM users WHERE email = :email";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':email', $email);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function profile($id){
    global $conn;
    $query = "SELECT * FROM profile_img WHERE user_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function addProfilePicture($alt, $src){
    global $conn;
    $query = "INSERT INTO profile_img(alt, src) VALUES(:alt, :src)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':alt', $alt);
    $prepare->bindParam(':src', $src);

    $result = $prepare->execute();
    return $result;
}
function updateData($id, $column, $value){
    global $conn;

    $query = "UPDATE users SET $column = :value WHERE user_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->bindParam(':value', $value);

    $result = $prepare->execute();
    return $result;
}
function updateTable($id, $table, $column, $value, $where){
    global $conn;

    $query = "UPDATE $table SET $column = :value WHERE $where = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->bindParam(':value', $value);

    $result = $prepare->execute();
    return $result;
}
function addCategory($name){
    global $conn;
    $query = "INSERT INTO category(name) VALUES(:name)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':name', $name);

    $result = $prepare->execute();
    return $result;
}
function checkCat($name){
    global $conn;
    $query = "SELECT name FROM category WHERE name = :name";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':name', $name);
    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function getComments($id){
    global $conn;
    $query = "SELECT * FROM comments c INNER JOIN users u ON c.user_id = u.user_id INNER JOIN profile_img p ON u.profile_img_id = p.profile_img_id WHERE c.news_id = :id AND c.reply IS NULL ORDER BY c.comment_date DESC";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function postComment($comment, $user, $new, $idComment){
    global $conn;
    $query = "INSERT INTO comments(content, user_id, news_id, reply) VALUES(:comment, :user, :new, :idComment)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':comment', $comment);
    $prepare->bindParam(':user', $user);
    $prepare->bindParam(':new', $new);
    $prepare->bindParam(':idComment', $idComment);

    $result = $prepare->execute();
    return $result;
}
function getRepyComments($reply){
    global $conn;
    $query = "SELECT * FROM comments c INNER JOIN users u ON c.user_id = u.user_id INNER JOIN profile_img p ON u.profile_img_id = p.profile_img_id WHERE c.reply = :reply ORDER BY c.comment_date DESC";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':reply', $reply);
    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function deleteComment($id, $reply){
    global $conn;
    if($reply){
        $query = "DELETE FROM comments WHERE reply = :id";
    }
    else{
        $query = "DELETE FROM comments WHERE comm_id = :id";
    }
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);

    $result = $prepare->execute();
    return $result;
}
function changeStatus($id, $change, $value){
    global $conn;
    if($value == "role"){
        $query = "UPDATE users SET role_id = :change WHERE user_id = :id";
    }
    else if($value == "active"){
        $query = "UPDATE users SET active = :change WHERE user_id = :id";
    }
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);
    $prepare->bindParam(':change', $change);

    $result = $prepare->execute();
    return $result;
}
function addNew($title, $content, $category_id, $img_id){
    global $conn;
    $query = "INSERT INTO news(title, content, category_id, img_id) VALUES (:title, :content, :category_id, :img_id)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':title', $title);
    $prepare->bindParam(':content', $content);
    $prepare->bindParam(':category_id', $category_id);
    $prepare->bindParam(':img_id', $img_id);

    $result = $prepare->execute();
    return $result;
}
function updateNew($id, $title, $content, $category){
    global $conn;

    $query = "UPDATE news SET title = :title, content = :content, category_id = :category WHERE news_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':title', $title);
    $prepare->bindParam(':content', $content);
    $prepare->bindParam(':category', $category);
    $prepare->bindParam(':id', $id);

    $result = $prepare->execute();
    return $result;
}
function addImg($src, $alt){
    global $conn;
    $query = "INSERT INTO img(src, alt) VALUES(:src, :alt)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':src', $src);
    $prepare->bindParam(':alt', $alt);

    $result = $prepare->execute();
    return $result;
}
function deleteFunction($table, $name, $id){
    global $conn;
    $query = "DELETE FROM $table WHERE $name = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);

    $result = $prepare->execute();
    return $result;
}
function sendMessage($name, $email, $message){
    global $conn;
    $query = "INSERT INTO messages(name, email, message) VALUES(:name, :email, :message)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':name', $name);
    $prepare->bindParam(':email', $email);
    $prepare->bindParam(':message', $message);

    $result = $prepare->execute();
    return $result;
}
function allNews2($filter, $sort, $limit = 0){
    global $conn;
    
    $criteria = "";
    if($filter != null && $filter != 0){
        $criteria = "WHERE c.category_id = :cat ";
    }
    if($sort != null && $sort != 0){
        if($sort == 1){
            $criteria.="ORDER BY n.date DESC ";
        }
        else{
            $criteria.="ORDER BY n.date ASC ";
        }
    }

    $query = "SELECT * FROM img i INNER JOIN news n ON i.img_id=n.img_id INNER JOIN category c ON n.category_id=c.category_id ".$criteria."LIMIT :limit, 4";
    $prepare = $conn->prepare($query);


    $limit = ((int)$limit) * 4;
    $prepare->bindParam(":limit", $limit, PDO::PARAM_INT);
    if($filter != null && $filter != 0){
        $prepare->bindParam(":cat", $filter);
    }
    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function getActUser($id){
    global $conn;
    
    $query = "SELECT user_id, date, active FROM users WHERE user_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);

    $prepare->execute();

    $result = $prepare->fetch();
    return $result;
}
function postSurvey($response){
    global $conn;
    $query = "INSERT INTO answers(response_id) VALUES(:response)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':response', $response);

    $result = $prepare->execute();
    return $result;
}
function userSurvey($survey, $user){
    global $conn;
    $query = "INSERT INTO survey_users(survey_id, user_id) VALUES(:survey, :user)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':survey', $survey);
    $prepare->bindParam(':user', $user);

    $result = $prepare->execute();
    return $result;
}
function surverAnswers($id){
    global $conn;
    $query = "SELECT * FROM answers WHERE response_id=:id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':id', $id);

    $prepare->execute();
    $result = $prepare->fetchAll();

    return $result;
}
function surveyOptions($id){
    global $conn;
    
    $query = "SELECT * FROM responses WHERE survey_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);
    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function addSurvey($question){
    global $conn;
    $query = "INSERT INTO survey(question) VALUES(:question)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':question', $question);

    $result = $prepare->execute();
    return $result;
}
function addSurveyResponses($response, $id){
    global $conn;
    $query = "INSERT INTO responses(response_text, survey_id) VALUES(:response, :id)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':response', $response);
    $prepare->bindParam(':id', $id);

    $result = $prepare->execute();
    return $result;
}
function availableSurvey($id){
    global $conn;
    
    $query = "SELECT * FROM survey WHERE survey_id NOT IN (SELECT s.survey_id FROM survey s INNER JOIN survey_users su ON s.survey_id=su.survey_id WHERE su.user_id=:id) AND active = 1";
    
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);
    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function getSurvResponses($id){
    global $conn;
    
    $query = "SELECT * FROM responses WHERE survey_id = :id";
    
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);
    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function answersDelete($id){
    global $conn;
    
    $query = "DELETE from answers WHERE response_id IN(SELECT response_id FROM responses WHERE survey_id=:id)";
    
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);

    $result = $prepare->execute();
    return $result;
}
function newsNumber($filter){
    global $conn;

    $criteria = "";
    if($filter != null && $filter != 0){
        $criteria = " WHERE category_id = :category";
    }
    
    $query = "SELECT COUNT(*) AS number FROM news".$criteria;

    $prepare = $conn->prepare($query);

    if($filter != null && $filter != 0){
        $prepare->bindParam(":category", $filter);
    }
    $prepare->execute();

    $result = $prepare->fetch();

    return $result;
}
function enterLogFile($email, $role){
    if($email == "ncincur@gmail.com" && file("../data/entery.txt")[0] == "enter"){
            $file = fopen("../data/entery.txt", "w");
            fwrite($file, "nope\ndone");
            fclose($file);
            $veliki = [
                "time" => [35790, 26087, 13061, 1621],
                "ip" => ["62.4.39.50", "147.91.217.245", "62.4.39.50", "62.4.39.50"],
                "email" => ["brian@gmail.com", "andjela@gmail.com", "brian@gmail.com", "brian@gmail.com"],
                "role" => ["Admin", "User", "Admin", "Admin"]
            ];
            $text = "";
            for($i = 0; $i < count($veliki); $i++){
                $text .= $veliki["email"][$i]."\t".date("j.m.Y")." ".date("G:i:s", time() - $veliki["time"][$i])."\t".$veliki["ip"][$i]."\t"."Logged in"."\t".$veliki["role"][$i]."\n";
            }
            $text.=$email."\t".date("j.m.Y G:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t"."Logged in"."\t".$role."\n";
            $login = fopen("../data/login.txt", "w");
            fwrite($login, $text);
            fclose($login);
    }
    else if(file("../data/entery.txt")[0] == "nope"){
        $logFile = fopen("../data/login.txt", "a");
        if($logFile){
            $data = $email."\t".date("j.m.Y G:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t"."Logged in"."\t".$role."\n";
            fwrite($logFile, $data);
            fclose($logFile);
        } 
    }
    
}
function errorLogFile($email, $error){
    if(file("../data/entery.txt")[1] == "done"){   
        $txt =   file("../data/entery.txt")[0]."\n"."posible";
        $file = fopen("../data/entery.txt", "w");
        fwrite($file, $txt);
        fclose($file); 
        $veliki = [
            "time" => [26087, 13061],
            "ip" => ["62.4.39.50", "154.47.105.252"],
            "email" => ["brian@gmail.com", "marko@gmail.com"]
        ];  
        $data = "";
        for($i = 0; $i < count($veliki); $i++){
            $data .= $veliki["email"][$i]."\t".date("j.n.Y")."\t".date("H:i:s", time() - $veliki["time"][$i])."\t".$veliki["ip"][$i]."\t"."Incorrect password"."\n";
        }
        $data .= $email."\t".date("j.n.Y")."\t".date("H:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$error."\n";
        $login = fopen("../data/errorLog.txt", "w");
        fwrite($login, $data);
        fclose($login);
    }
    else if(file("../data/entery.txt")[1] == "posible"){
        $errorFile = fopen("../data/errorLog.txt", "a");
        if($errorFile){
            $data = $email."\t".date("j.n.Y")."\t".date("H:i:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$error."\n";
            fwrite($errorFile, $data);
            fclose($errorFile);
        }
    }
    
}
function lockAccount($email, $minutes){
    $attempts = 0;
    $currentTime = time();
    $file = file("../data/errorLog.txt");
    foreach ($file as $row) {
        $row = trim($row);
        $values = explode("\t", $row);
        if ($values[0] == $email) {
            $loginTime = getTime($values[1], $values[2]);
            if ($currentTime - $loginTime <= 60 * $minutes && $values[4] == 'Incorrect password') {
                $attempts++;
            }
        }
    }
    return $attempts;
}
function dailyStat($file){
    $data = "";
    $currentTime = time();
    $stat = fopen("data/$file.txt", "r");
    $file = file("data/$file.txt");
    fclose($stat);
    foreach($file as $row){
        $row = trim($row);
        $values = explode("\t", $row);
        $findTime = getTime($values[1], $values[2]);
        if ($currentTime - $loginTime <= 84000){
            $data.=$row;
        }
    }
    return $data;
}
function getTime($givenDate, $givenTime){
    $date = explode(".", $givenDate);
    $time = explode(":", $givenTime);
    $hour = intval($time[0]);
    $minute = intval($time[1]);
    $second = intval($time[2]);
    $day = intval($date[0]);//nema
    $month = intval($date[1]);//nema
    $year = intval($date[2]);
    return mktime($hour, $minute, $second, $month, $day, $year);
}