<?php 
if(isset($_SESSION['user'])):
        if($_SESSION['user']->role_id == 1):
            $user = $_SESSION['user'];
            $survey = selectAll("survey");
            $messages = selectAll("messages");
?>
<div class="container py-2">
    <div class="container my-5">
        <div class="row" id="model">
            <div class="col-lg-9 m-auto">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">MESSAGES</h4>
                </div>
                <?php if(count($messages) == 0):?>
                    <h2 class="text-center mt-5">There is no messages</h2>
               <?php else:?>
                    <?php foreach($messages as $m):?>
                    <div class="bg-white border border-top-0 p-4">
                        <div class="media position-relative">
                            <input type="hidden" value="2"> 
                            <button class="border-0 text-danger nc-delete-message position-absolute" data-id="<?=$m->message_id?>"><i class="fas fa-times" aria-hidden="true"></i></button>
                            <div class="media-body">
                                <h6><p class="text-secondary font-weight-bold mb-0"><?=$m->name?></p> <small><i><?=date("d M Y", strtotime($m->message_date))?></i></small></h6>
                                <p><?=$m->message?></p>    
                                <a href="mailto:<?=$m->email?>" class="btn btn-sm btn-outline-secondary replyComment">Reply</a>                                                
                            </div>
                        </div>
                    </div>    
                    <?php endforeach?>
               <?php endif?>
            </div>
        </div>
    </div>
</div>
<?php else:
    include_once('views/pages/index.php');
?>
<?php endif?>
<?php else:
    include_once('views/pages/index.php');
?>
<?php endif?>