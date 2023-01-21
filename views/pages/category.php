<?php    
    $headline = selectHeadlines();
    $cid=1;
?>
    <!-- News With Sidebar Start -->
    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php foreach($categories as $c):?>
                        <?php
                            $topCategories = $conn->query("SELECT * FROM img i INNER JOIN news n ON i.img_id=n.img_id INNER JOIN category c ON n.category_id=c.category_id WHERE n.category_id=".$cid." ORDER BY n.date DESC LIMIT 2")->fetchAll();
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title">
                                    <h4 class="m-0 text-uppercase font-weight-bold">Category: <?=$c->name?></h4>
                                    <a class="text-secondary font-weight-medium text-decoration-none category-btn" data-view="<?=$c->category_id?>" href="#">View All</a>
                                </div>
                            </div>
                            <?php foreach($topCategories as $tc):?>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center bg-white mb-3 nemanja" style="height: 110px;">
                                        <img src="img/<?=$tc->src?>" alt="<?=$tc->alt?>">
                                        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase category-btn font-weight-semi-bold p-1 mr-2" data-view="<?=$c->category_id?>" href="#"><?=$c->name?></a>
                                                <p class="text-body mb-0"><small><?=date("l, j M Y", strtotime($tc->date))?></small></p>
                                            </div>
                                            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="single.php?single=<?=$tc->news_id?>">
                                            <?php if(strlen($tc->title) > 30):?>
                                                <?=substr($tc->title, 0, 30)."..."?>
                                            <?php else:?>
                                                <?=$tc->title?>
                                            <?php endif?> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach?>    
                            <?php $cid++?>
                        </div>
                    <?php endforeach?>    
                </div>                
                <?php include_once "views/fixed/sidebar.php"?>  
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
