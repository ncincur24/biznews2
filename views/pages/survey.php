<?php 
    if(isset($_SESSION['user'])):
        $user = $_SESSION['user'];
        $allSurv = selectAll('survey');
        $availabelSurvey = availableSurvey($user->user_id);
    
?>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">SURVEY</h4>
                </div>
                <?php if(count($availabelSurvey) == 0):?>
                    <h2 class="text-center mt-5">There is no any survey</h2>
                <?php else:?>
                <div class="bg-white border border-top-0 p-4 mb-3">
                    <p>Please fill out this survey, it is anonymus just for statistic research</p>
                    <?php foreach($availabelSurvey as $a):?>
                        <?php $responses = getSurvResponses($a->survey_id)?>
                    <h4><?=$a->question?></h4>
                        <?php foreach($responses as $r):?>
                            <div class="form-check radios-response">
                                <input class="form-check-input" type="radio" value="<?=$r->response_id?>" name="response_<?=$a->survey_id?>" id="response_<?=$r->response_id?>" />
                                <label class="form-check-label" for="response_<?=$r->response_id?>">
                                    <?=$r->response_text?>
                                </label>
                            </div>
                        <?php endforeach?>
                    <input type="button" value="Done" data-survey="<?=$a->survey_id?>" class="btn btn-primary my-3 send-response" />
                    <?php endforeach?>
                </div>
                <?php endif?>
            </div>
        </div>
    </div>
<?php else:
    include_once('views/pages/index.php');
?>
<?php endif?>