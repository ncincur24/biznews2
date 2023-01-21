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
                                    <a class="dropdown-item" href="index.php?page=user">Settings</a>
                                    <a class="dropdown-item" href="index.php?page=survey">Survey</a> 
                                    <?php if($user->role_id == 1):?>                           
                                        <a class="dropdown-item" href="index.php?page=admin">Admin</a>   
                                        <a class="dropdown-item" href="index.php?page=add-new">Add new</a>   
                                        <a class="dropdown-item" href="index.php?page=messages">Messages</a>   
                                        <a class="dropdown-item" href="index.php?page=manage-survey">Results</a>   
                                        <a class="dropdown-item" href="index.php?page=categories-admin">Categories</a>   
                                        <a class="dropdown-item" href="index.php?page=stat">Stat</a>   
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
                            <a href="index.php?page=<?=substr($n->href, 0, strlen($n->href)-4)?>" class="nav-item nav-link"><?=$n->title?></a>
                        <?php endforeach?>    
                        <?php if(!isset($_SESSION['user'])):?>
                        <a href="index.php?page=registration" class="d-block d-lg-none nav-item nav-link">Register</a>
                        <a href="index.php?page=login" class="d-block d-lg-none nav-item nav-link">Login</a>
                        <?php endif?>    
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
                                            <a class="dropdown-item" href="index.php?page=survey">Survey</a> 
                                            <?php if($user->role_id == 1):?>                           
                                                <a class="dropdown-item" href="index.php?page=admin">Admin</a>   
                                                <a class="dropdown-item" href="index.php?page=add-new">Add new</a>   
                                                <a class="dropdown-item" href="index.php?page=messages">Messages</a>   
                                                <a class="dropdown-item" href="index.php?page=results">Results</a>   
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
                            <li class="d-flex align-items-center nav-item border-secondary">
                                <p class="p-3 text-body small mb-0"><?=date("l, j M Y");?></p>
                            </li>
                            <?php if(!isset($_SESSION['user'])):?>
                            <li class="nav-item border-right border-left border-secondary">
                                <a class="nav-link text-body small" href="index.php?page=registration">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-body small" href="index.php?page=login">Login</a>
                            </li>   
                            <?php endif?>
                        </ul>
                    </div>
            </nav>
    </div>