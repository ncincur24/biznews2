<?php
    $trending = trendingNews();?>
<div class="col-lg-4">
                    <!-- Social Follow Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <?php foreach($social as $s):?>
                                <a href="<?=$s->href?>" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #<?=$s->background?>;">
                                    <i class="fab fa-<?=$s->class?> text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                    <span class="font-weight-medium"><?=$s->name?></span>
                                </a>
                            <?php endforeach?>
                            </a>
                        </div>
                    </div>
                    <!-- Social Follow End -->

                    <!-- Popular News Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tranding News</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <?php foreach($trending as $t):?>
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2 category-btn" data-view="<?=$t->category_id?>" href="#"><?=$t->name?></a>
                                        <a><small><?=date("l, j M Y", strtotime($t->date))?></small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="index.php?page=single&single=<?=$t->news_id?>">
                                    <?php if(strlen($t->title) > 35):?>
                                            <?=substr($t->title, 0, 35)."..."?>
                                        <?php else:?>
                                            <?=$t->title?>
                                        <?php endif?> 
                                    </a>
                                </div>
                            </div>
                            <?php endforeach?>
                        </div>
                    </div>
                    <!-- Popular News End -->
                    <!-- Newsletter End -->

                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                <?php foreach($categories as $c):?>
                                    <a href="#" data-view="<?=$c->category_id?>" class="btn btn-sm btn-outline-secondary m-1 category-btn"><?=$c->name?></a>
                                <?php endforeach?>    
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
                </div>