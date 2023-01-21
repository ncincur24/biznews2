<?php

require_once "config.php";

try{
    $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
}
catch(PDOException $e){
    echo "Not connected".$e->getMessage();
}
function pageStat($page)
{
    $open = fopen("data/pageStat.txt", "a");
    if ($open) {
        $text = $_SERVER['PHP_SELF']."?page=".$page."\t".date("j.n.Y")."\t".date("H:i:s")."\t".$_SERVER['REMOTE_ADDR']."\n";
        fwrite($open, $text);
        fclose($open);
    }
}
