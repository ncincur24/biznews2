<?php
    session_start();
    header("Content-type: application/json");
    // if(isset($_GET['btn'])){
        include "functions.php";
        include "../connection/database.php";

        try{
            $limit = $_GET["limit"];
            $filter = $_GET["category"];
            $sort = isset($_GET["sort"]) ? $_GET["sort"] : null;

            $news = allNews2($filter, $sort, $limit);
            $novi = [];
            
            $dates = [];
             foreach($news as $new){
                array_push($dates, date("l, j M Y", strtotime($new->date)));
                // foreach($new as $n){
                //     iconv("UTF-8", "UTF-8//IGNORE", utf8_encode($n));
                // }     
                // $novi = array_map("utf8_encode", $new);
            }

            // $utfEncodedArray = array_map("utf8_encode", $news );
            // var_dump($novi);
            // $pages = newsNumber($filter)->number;
            


            echo json_encode([
                "new"=>$news,
                "pages"=>$pages,
                "date"=>$dates
            ]);
            http_response_code(201);
        }        
        catch(PDOException $exception){
            http_response_code(500);
        }
    // }
    // else{
    //     http_response_code(404);
    // }
