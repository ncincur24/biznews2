<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "GET" && $_SESSION['user']->role_id == 1)
{
    header("Content-Disposition: attachment; filename=categories.xls");
    header("Content-Type: application/x-msexcel");
    header('Content-Type: application/vnd.ms-excel');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header("Pragma: no-cache");
    include "../connection/database.php"; 
    include "functions.php";
        
    $categories = selectAll("category");
    $export_string = "Category Id\tCategory Name\n";
    foreach($categories as $category) {
        $export_string .= $category->category_id . "\t" . $category->name ."\n";
    }
    echo $export_string;
}
else{
    header("Location: index.php");
}

    