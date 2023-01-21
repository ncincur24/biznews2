<?php
    $nav = selectAll("nav");
    $social = selectAll("social");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BizNews - Free News Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3a94136a62.js" crossorigin="anonymous"></script>
</head>



<body>
    <!-- Topbar Start -->
    <div class="container-fluid d-none d-lg-block">
        <div class="row align-items-center justify-content-between bg-white py-2 px-lg-5">
            <div class="col-lg-4">
                <a href="index.php" class="navbar-brand p-0 d-none d-lg-block">
                    <h1 class="m-0 display-4 text-uppercase text-primary">Biz<span class="text-secondary font-weight-normal">News</span></h1>
                </a>
            </div>
            <?php if(isset($_SESSION['user'])):?>
                <?php $user = $_SESSION['user'];?>
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="row justify-content-end align-items-center">
                            <div id="mini-picture">
                            <img src="img/<?=$user->src?>" alt="<?=$user->alt?>" class="img-fluid" id="en" />
                            </div>
                            <div class="dropdown">
                                <p class="mx-3 mb-0 dropdown-toggle font-weight-bold" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$user->name?> <?=$user->last_name?></p>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="user.php">Settings</a>
                                    <?php if($user->survey == 0):?>
                                        <a class="dropdown-item" href="survey.php">Survey</a> 
                                    <?php endif?>
                                    <?php if($user->role_id == 1):?>                           
                                        <a class="dropdown-item" href="admin.php">Admin</a>   
                                        <a class="dropdown-item" href="add-new.php">Add new</a>   
                                        <a class="dropdown-item" href="messages.php">Messages</a>   
                                        <a class="dropdown-item" href="results.php">Results</a>   
                                    <?php endif?>  
                                    <a class="dropdown-item" href="models/sign-out.php?id=<?$user->user_id?>">Sign Out</a>                              
                                </div>
                            </div>
                        </div>    
                    </div>
            <?php endif?>
        </div>
    </div>
    <div class="container-fluid p-0">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
                <a href="index.html" class="navbar-brand d-block d-lg-none">
                    <h1 class="m-0 display-4 text-uppercase text-primary">Biz<span class="text-white font-weight-normal">News</span></h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <?php foreach($nav as $n):?>
                            <a href="<?=$n->href?>" class="nav-item nav-link"><?=$n->title?></a>
                        <?php endforeach?>    
                        <a href="registration.php" class="d-block d-lg-none nav-item nav-link">Register</a>
                        <a href="login.php" class="d-block d-lg-none nav-item nav-link">Login</a>
                        <?php if(isset($_SESSION['user'])):?>
                        <?php $user = $_SESSION['user'];?>
                            <div class="col-lg-4 d-block d-lg-none">
                                <div class="row justify-content-start mt-3 align-items-center">
                                    <div id="mini-picture">
                                    <img src="img/<?=$user->src?>" alt="<?=$user->alt?>" class="img-fluid" id="en" />
                                    </div>
                                    <div class="dropdown">
                                        <p class="mx-3 mb-0 dropdown-toggle font-weight-bold" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$user->name?> <?=$user->last_name?></p>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="user.php">Settings</a>
                                            <?php if($user->survey == 0):?>
                                                <a class="dropdown-item" href="survey.php">Survey</a> 
                                            <?php endif?>
                                            <?php if($user->role_id == 1):?>                           
                                                <a class="dropdown-item" href="admin.php">Admin</a>   
                                                <a class="dropdown-item" href="add-new.php">Add new</a>   
                                                <a class="dropdown-item" href="messages.php">Messages</a>   
                                                <a class="dropdown-item" href="results.php">Results</a>   
                                            <?php endif?>  
                                            <a class="dropdown-item" href="models/sign-out.php?id=<?$user->user_id?>">Sign Out</a>                              
                                        </div>
                                    </div>
                                </div>    
                            </div>
                    <?php endif?>
                    </div>
                </div>
                    <div class="d-none d-lg-block navbar navbar-expand-sm bg-dark p-0">
                        <ul class="navbar-nav ml-n2">
                            <li class="d-flex align-items-center nav-item border-right border-secondary">
                                <p class="p-3 text-body small mb-0"><?=date("l, j M Y");?></p>
                            </li>
                            <li class="nav-item border-right border-secondary">
                                <a class="nav-link text-body small" href="registration.php">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-body small" href="login.php">Login</a>
                            </li>   
                        </ul>
                    </div>
            </nav>
    </div>