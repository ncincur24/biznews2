<?php
    session_start();
    header("Content-type: application/json");
    if(isset($_GET['btn'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $limit = $_GET["limit"];
            $filter = isset($_GET["category"]) ? $_GET["category"] : null;
            $sort = isset($_GET["sort"]) ? $_GET["sort"] : null;

            $news = allNews2($filter, $sort, $limit);
            $pages = newsNumber($filter)->number;
            $dates = [];
            $comments = [];
            foreach($news as $n){
                array_push($dates, date("l, j M Y", strtotime($n->date)));
            }
            
            echo json_encode([
                "news" => $news,
                "pages" => $pages,
                "dates" => $dates
            ]);
        }        
        catch(PDOException $exception){
            http_response_code(500);
        }
    }
    else{
        http_response_code(404);
    }
