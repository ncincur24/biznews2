<?php 
    if(isset($_GET['single'])):
        $new = singleNew($_GET['single']);
        $headline = selectHeadlines();
        $comments = getComments($new->news_id, null);    
?>


    <!-- News With Sidebar Start -->
    <div class="container-fluid mt-5" id="single-modal">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">
                        <img class="img-fluid w-100" src="img/<?=$new->src?>" alt="<?=$new->alt?>" style="object-fit: cover;">
                        <div class="bg-white border border-top-0 p-4">
                            
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" data-cat="<?=$new->category_id?>"
                                href="index.php?page=all-news&filter=1&cat=<?=$new->category_id?>"><?=$new->name?></a>
                                <p class="text-body mb-0"><?=date("l, j M Y", strtotime($new->date))?></p>
                                <?php if(isset($_SESSION['user'])):?>
                                <?php if($_SESSION['user']->role_id == 1):?>
                                <input type="button" data-img="<?=$new->img_id?>" data-src="<?=$new->src?>" value="DELETE NEW" class="mt-1 btn btn-danger btn-sm" id="deleteNew" />
                                <input type="button" data-img="<?=$new->img_id?>" data-src="<?=$new->src?>" value="EDIT NEW" class="mt-1 btn btn-primary btn-sm ml-4" id="editNew" />
                                <?php endif?>
                                <?php endif?>
                            <h1 class="mb-3 text-secondary text-uppercase font-weight-bold"><?=$new->title?></h1>
                            <p><?=$new->content?></p>
                        </div>
                    </div>
                    <!-- News Detail End -->

                    <!-- Comment List Start -->
                    <div class="mb-3" id="reloadDiv">
                        <div id="rld">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold"><?=count($comments)?> Comments</h4>
                        </div>
                            <?php if(count($comments) > 0):?>
                                <div class="bg-white border border-top-0 p-4">
                                    <?php foreach($comments as $c):?>
                                        <?php $reply = getRepyComments($c->comm_id)?>
                                        <div class="media mb-4 position-relative">
                                            <input type="hidden" value="<?=$c->comm_id?>" />
                                        <?php if(isset($_SESSION['user'])):?>
                                        <?php $activeUser = $_SESSION['user'];?>
                                            <?php if($activeUser->role_id == 1 || $activeUser->user_id == $c->user_id):?>  
                                            <button class="border-0 text-danger nc-delete position-absolute"><i class="fas fa-times" aria-hidden="true"></i></button>
                                            <?php endif?>
                                        <?php endif?>
                                            <img src="img/<?=$c->src?>" alt="<?=$c->alt?>" class="img-fluid mr-3 mt-1" style="width: 45px;" />
                                            <div class="media-body">
                                                <h6><p class="text-secondary font-weight-bold mb-0"><?=$c->name?> <?=$c->last_name?></p> <small><i><?=date("d M Y", strtotime($c->comment_date))?></i></small></h6>
                                                <p><?=$c->content?></p>
                                                <input type="button" value="Reply" class="btn btn-sm btn-outline-secondary replyComment" />
                                                <?php if(count($reply) > 0):?>
                                                    <?php foreach($reply as $r):?>
                                                    <div class="media mt-4 position-relative">
                                                        <input type="hidden" value="<?=$r->comm_id?>" />        
                                                    <?php if(isset($_SESSION['user'])):?>
                                                        <?php if($activeUser->role_id == 1 || $activeUser->user_id == $r->user_id):?>    
                                                        <button class="border-0 text-danger nc-delete position-absolute"><i class="fas fa-times" aria-hidden="true"></i></button>
                                                        <?php endif?>
                                                    <?php endif?>
                                                    <img src="img/<?=$r->src?>" alt="<?=$r->alt?>" class="img-fluid mr-3 mt-1" style="width: 45px;" />
                                                        <div class="media-body">
                                                        <h6><p class="text-secondary font-weight-bold mb-0"><?=$r->name?> <?=$r->last_name?></p> <small><i><?=date("d M Y", strtotime($r->comment_date))?></i></small></h6>
                                                        <p><?=$r->content?></p>
                                                        </div>
                                                    </div>
                                                    <?php endforeach?>
                                                <?php endif?>    
                                            </div>
                                        </div>
                                    <?php endforeach?>  
                                </div>
                            <?php endif?>    
                            </div>
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                                            
                    <?php if(isset($_SESSION['user'])):?>
                        <div class="mb-3">
                        <i class="fa-solid fa-x"></i>
                            <div class="section-title mb-0">
                                <h4 class="m-0 text-uppercase font-weight-bold" id="leave-reply">Leave a comment</h4>
                            </div>
                            <div class="bg-white border border-top-0 p-4">
                                <form>
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea id="comment" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="hidden" value="<?=$_SESSION['user']->user_id?>" id="idUser" />
                                        <input type="hidden" value="<?=$_GET['single']?>" id="idNew" />
                                        <input type="button" value="Leave a comment" class="btn btn-primary font-weight-semi-bold py-2 px-3" id="postComment" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="mb-3">
                            <div class="section-title mb-0">
                                <p class="m-0">You want to post comment please <a href="index.php?page=login">login</a> or <a href="index.php?page=registration">register</a></p>
                            </div>
                        </div>
                    <?php endif?> 
                    <!-- Comment Form End -->
                </div>
                <?php include_once "views/fixed/sidebar.php";?>
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
<?php else:
    include_once('views/pages/index.php');
?>    
<?php endif?>