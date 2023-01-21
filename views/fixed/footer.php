<?php
    $trending = trendingNews();
?>
<div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Get In Touch</h5>
                <p class="font-weight-medium"><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York, USA</p>
                <p class="font-weight-medium"><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                <p class="font-weight-medium"><i class="fa fa-envelope mr-2"></i>info@example.com</p>
                <h6 class="mt-4 mb-3 text-white text-uppercase font-weight-bold">Follow Us</h6>
                <div class="d-flex justify-content-start">
                    <?php foreach($social as $s):?>
                        <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="<?=$s->href?>"><i class="fab fa-<?=$s->class?>"></i></a>
                    <?php endforeach?>
                    <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="docs2.pdf"><i class="fa fa-file-text"></i></i></a>                    
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Popular News</h5>
                <?php foreach($trending as $t):?>
                <div class="mb-3">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2 category-btn" data-view="<?=$t->category_id?>" href="#"><?=$t->name?></a>
                        <a><small><?=date("l, j M Y", strtotime($t->date))?></small></a>
                    </div>
                    <a class="small text-body text-uppercase font-weight-medium" href="index.php?page=single&single=<?=$t->news_id?>">
                                    <?php if(strlen($t->title) > 50):?>
                                            <?=substr($t->title, 0, 50)."..."?>
                                        <?php else:?>
                                            <?=$t->title?>
                                        <?php endif?> 
                                    </a>
                </div>
                <?php endforeach?>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Categories</h5>
                <div class="m-n1" id="footer-cat">
                    <?php foreach($categories as $c):?>
                        <a href="#" data-view="<?=$c->category_id?>" data-id="<?=$c->category_id?>" class="btn btn-sm btn-secondary m-1 category-btn"><?=$c->name?></a>
                    <?php endforeach?>    
                </div>
                <div class="row mt-5">
                    <a href="models/export-author.php">About author</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
        <p class="m-0 text-center">&copy; <a href="#">Biznews</a>. All Rights Reserved Nemanja Cincur. Design by <a href="https://htmlcodex.com">HTML Codex</a></p>
        <p class="text-center">Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
    </div>