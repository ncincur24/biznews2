<?php 
    session_start();
    include "connection/database.php";    
    include "models/functions.php";    
    $headline = selectHeadlines();
    $categories = selectAll("category");
    include_once "includes/head.php";
?>

    <!-- Main News Slider Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 px-0">
                <div class="owl-carousel main-carousel position-relative">
                <!-- PITAJ ZASTOOOO!!! -->
                <!-- SLAJDER - 3 VIJESTI -->
                    <?php foreach($headline as $key=>$h):?>
                        <?php if($key > 2) break;?>
                            <div class="position-relative overflow-hidden" style="height: 500px;">
                                <img class="img-fluid h-100" alt="<?=$h->alt?>" src="img/<?=$h->src?>" style="object-fit: cover;">
                                <div class="overlay">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 float-left"
                                        href="all-news.php?filter=1&cat=<?=$h->category_id?>"><?=$h->name?></a>
                                        <p class="text-white mb-0 ml-3 float-left"><?=date("l, j M Y", strtotime($h->date))?></p>
                                    </div>
                                    <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="single.php?single=<?=$h->news_id?>">
                                        <?php if(strlen($h->title) > 40):?>
                                            <?=substr($h->title, 0, 40)."..."?>
                                        <?php else:?>
                                            <?=$h->title?>
                                        <?php endif?> 
                                    </a>
                                </div> 
                            </div>
                    <?php endforeach?>   
                </div>
            </div>
            <div class="col-lg-5 px-0">
                <div class="row mx-0">
                    <!-- DESNI DIO - 4 VIJESTI -->
                    <?php foreach($headline as $key=>$h):?>     
                        <?php if($key < 3) continue;?>                   
                        <?php if($key > 6) break;?>                   
                        <div class="col-md-6 px-0">
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid w-100 h-100" alt="<?=$h->alt?>" src="img/<?=$h->src?>" style="object-fit: cover;">
                                <div class="overlay">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 float-left"
                                        href="all-news.php?filter=1&cat=<?=$h->category_id?>"><?=$h->name?></a>
                                        <p class="text-white float-left"><small><?=date("l, j M Y", strtotime($h->date))?></small></p>
                                    </div>
                                    <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="single.php?single=<?=$h->news_id?>">
                                        <?php if(strlen($h->title) > 30):?>
                                            <?=substr($h->title, 0, 30)."..."?>
                                        <?php else:?>
                                            <?=$h->title?>
                                        <?php endif?> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach?>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News Slider End -->



    <!-- News With Sidebar Start -->
    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Latest News</h4>
                            </div>
                        </div>
                        <?php foreach($headline as $key=>$h):?>  
                            <?php if($key < 7) continue;?>
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="img/<?=$h->src?>" alt="<?=$h->alt?>" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href="all-news.php?filter=1&cat=<?=$h->category_id?>"><?=$h->name?></a>
                                            <p><small><?=date("l, j M Y", strtotime($h->date))?></small></p>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?single=<?=$h->news_id?>">
                                            <?php if(strlen($h->title) > 20):?>
                                                <?=substr($h->title, 0, 20)."..."?>
                                            <?php else:?>
                                                <?=$h->title?>
                                            <?php endif?> 
                                        </a>
                                        <p class="m-0">
                                        <?php if(strlen($h->content) > 30):?>
                                                <?=substr($h->content, 0, 30)."..."?>
                                            <?php else:?>
                                                <?=$h->content?>
                                            <?php endif?> 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>
                <?php include_once("includes/sidebar.php")?>                
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
<?php
    include_once("includes/footer.php");
?>

    