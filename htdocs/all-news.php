<?php 
    session_start();
    include "connection/database.php";    
    include "models/functions.php";    
    $headline = selectHeadlines();
    $categories = selectAll("category");
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
    $filter = 0;
    $catID = 0;
    $sortID = 0;
    $countNews = selectAll("news");
    if(isset($_GET['filter'])){
        if(isset($_GET['cat'])){
            if($_GET['cat'] != 0){
                $catID = $_GET['cat'];    
                $countNews = countNews($catID);  
            } 
        }
        if(isset($_GET['sort'])){
            if($_GET['sort'] != 0){
                $sortID = $_GET['sort']; 
            }        
        }
        $news = allNews($limit, 4, $catID, $sortID);
    }
    else{
        $news = allNews($limit, 4, null, null);
    }
    include_once "includes/head.php";
?>

    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-8">
                    <div class="row justify-content-center">
                        <select class="form-select mx-4" aria-label="Default select example" id="filterNews">
                            <option value="0">Categories</option>
                            <?php foreach($categories as $c):?>
                            <option value="<?=$c->category_id?>" <?php if($catID == $c->category_id):?>selected<?php endif?>><?=$c->name?></option>
                            <?php endforeach?>
                        </select>
                        <select class="form-select mx-4" aria-label="Default select example" id="orderNews">
                            <option value="0">Order by</option>
                            <option value="1" <?php if($sortID == 1):?>selected<?php endif?>><a href="index.php">Oldest</a></option>
                            <option value="2" <?php if($sortID == 2):?>selected<?php endif?>>Newest</option>
                        </select>
                        <input type="button" value="GO" id="filterBtn" class="btn btn-secondary">
                    </div>
                    <div class="row mt-5">
                        <?php foreach($news as $n):?>
                        <div class="col-lg-12">
                            <div class="row news-lg mx-0 mb-3">
                                <div class="col-md-6 h-100 px-0">
                                    <img class="img-fluid h-100" src="img/<?=$n->src?>" alt="<?$n->alt?>" style="object-fit: cover;">
                                </div>
                                <div class="col-md-6 d-flex flex-column border bg-white h-100 px-0">
                                    <div class="mt-auto p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                href="all-news.php?filter=1&cat=<?=$n->category_id?>"><?=$n->name?></a>
                                            <p class="text-body mb-0"><small><?=date("l, j M Y", strtotime($n->date))?></small></p>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?single=<?=$n->news_id?>">
                                            <?php if(strlen($n->title) > 15):?>
                                                <?=substr($n->title, 0, 15)."..."?>
                                            <?php else:?>
                                                <?=$n->title?>
                                            <?php endif?>  
                                        </a>
                                        <p class="m-0">
                                            <?php if(strlen($n->content) > 130):?>
                                                <?=substr($n->content, 0, 130)."..."?>
                                            <?php else:?>
                                                <?=$n->content?>
                                            <?php endif?>        
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border-top mt-auto p-4">
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i><?=count(getComments($n->news_id))?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach?>
                    </div>
                </div>
                <?php include_once("includes/sidebar.php")?>                
            </div>
            <ul class="pagination">    
                <?php for($i = 0; $i < ceil(count($countNews) / 4); $i++):?>
                <li class="page-item"><a class="page-link" href="all-news.php?limit=<?=$i?>&filter=1&cat=<?=$catID?>&sort=<?=$sortID?>"><?=($i+1)?></a></li>
                <?php endfor?>      
            </ul>
        </div>
    </div> 
    <!-- News With Sidebar End -->
<?php
    include_once("includes/footer.php");
?>

    