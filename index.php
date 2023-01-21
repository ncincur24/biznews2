<?php 
    session_start();
    include "connection/database.php";    
    include "models/functions.php";    
    $headline = selectHeadlines();
    $categories = selectAll("category");
	$social = selectAll("social");
	$nav = selectAll("nav");
    include_once "views/fixed/head.php";
    include_once "views/fixed/header.php";


    if(isset($_GET['page'])){
			$page = $_GET['page'];
			pageStat($page);
			switch($page){
				case "index":
					include_once('views/pages/index.php');
					break;
				case "all-news":
					include_once('views/pages/all-news.php');
					break;
				case "category":
					include_once('views/pages/category.php');
					break;
				case "contact":
					include_once('views/pages/contact.php');
					break;
				case "single":
					include_once('views/pages/single.php');
					break;
				case "login":
					include_once('views/pages/login.php');
					break;
				case "registration":
					include_once('views/pages/registration.php');
					break;
				case "survey":
					include_once('views/pages/survey.php');
					break;
				case "admin":
					include_once('views/pages/admin.php');
					break;
				case "add-new":
					include_once('views/pages/add-new.php');
					break;
				case "manage-survey":
					include_once('views/pages/manage-survey.php');
					break;
				case "user":
					include_once('views/pages/user.php');
					break;
				case "categories-admin":
					include_once('views/pages/categories-admin.php');
					break;
				case "messages":
					include_once('views/pages/messages.php');
					break;
				case "stat":
					include_once('views/pages/stat.php');
					break;
				default:
					include_once('views/pages/index.php');
			}
		}
        else {
			pageStat("index");
			include_once('views/pages/index.php');
		}

    include_once "views/fixed/footer.php";
    include_once "views/fixed/scripts.php";    