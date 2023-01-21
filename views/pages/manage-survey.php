<?php 
if(isset($_SESSION['user'])):
        if($_SESSION['user']->role_id == 1):
            $user = $_SESSION['user'];
            $survey = selectAll("survey");
?>
<div class="container my-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
             <h2 class="text-center">Manage survey</h2>
                <table class="table bg-white">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Question</th>
                            <th scope="col">Responses</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($survey as $s):?>                            
                        <?php $options = surveyOptions($s->survey_id);?>
                        <tr data-id="<?=$s->survey_id?>">
                            <td class="font-weight-bold position-relative">
                                <?=$s->question?>
                                <button class="border-0 text-danger nc-delete-survey position-absolute"><i class="fas fa-times" aria-hidden="true"></i></button>
                            </td>
                            <td>
                                <?php foreach($options as $o):?>
                                    <p><?=$o->response_text?>: <span class="font-weight-bold text-info"><?=count(surverAnswers($o->response_id))?></span></p>
                                <?php endforeach?>
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" <?php if($s->active == 1):?>checked<?php endif?> class="cb-survey">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>  
                        <?php endforeach?>  
                    </tbody>
                </table>
                <input type="button" class="btn btn-sm btn-primary rounded" id="add-survey-btn" value="+ Add survey" />
                <input type="text" class="form-control w-50 mt-3" placeholder="Question" id="add-survey" />
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