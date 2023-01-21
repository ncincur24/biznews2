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
function checkEmail($email){
    global $conn;
    $query = "SELECT email FROM users WHERE email = :email";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':email', $email);
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
function checkActive($email, $password){
    global $conn;
    $query = "SELECT active FROM users WHERE email = :email AND password = :password";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':password', $password);
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
    else{
        $query = "UPDATE users SET survey = :change WHERE user_id = :id";
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
function allNews($limit, $offset, $filter, $sort){
    global $conn;
    $criteria = "";
    if($filter != null){
        $criteria = "WHERE c.category_id = :cat ";
    }
    if($sort != null){
        if($sort == 1){
            $criteria.="ORDER BY n.date DESC ";
        }
        else{
            $criteria.="ORDER BY n.date ASC ";
        }
    }
    $lim = $limit * 4;
    $query = "SELECT * FROM img i INNER JOIN news n ON i.img_id=n.img_id INNER JOIN category c ON n.category_id=c.category_id ".$criteria."LIMIT :limit, 4";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":limit", $lim, PDO::PARAM_INT);
    if($filter != null){
        $prepare->bindParam(":cat", $filter);
    }

    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}
function countNews($id){
    global $conn;
    
    $query = "SELECT * FROM news n INNER JOIN category c ON n.category_id=c.category_id WHERE c.category_id = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);

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
function postSurvey($cat, $gender){
    global $conn;
    $query = "INSERT INTO survey(gender_id, category_id) VALUES(:gender, :cat)";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(':gender', $gender);
    $prepare->bindParam(':cat', $cat);

    $result = $prepare->execute();
    return $result;
}
function categoryResult($table1, $al1, $table2, $al2, $join,$id){
    global $conn;
    
    $query = "SELECT * FROM $table1 $al1 INNER JOIN $table2 s ON $al1.$join = $al2.$join WHERE $al1.$join = :id";
    $prepare = $conn->prepare($query);

    $prepare->bindParam(":id", $id);

    $prepare->execute();

    $result = $prepare->fetchAll();
    return $result;
}