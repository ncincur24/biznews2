<?php
    session_start();
    if(isset($_SESSION['user'])){
        if($_SESSION['user']->role_id == 1){
            include "connection/database.php";
            include "models/functions.php";
            $user = $_SESSION['user'];
            $social = selectAll("social");
            $categories = selectAll("category");
            include_once "includes/head.php";
        }
    }
    else{
        header("HTTP/1.0 404 Not Found");
    }
?>


<div class="container my-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">SURVEY RESULTS</h4>
                </div>
                <div class="bg-white border border-top-0 p-4 mb-3">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <?php foreach($categories as $c):?>
                            <p><?=$c->name?>: <?=count(categoryResult("category", "c", "survey", "s", "category_id",$c->category_id))?></p>
                            <?php endforeach?>
                        </div>
                        <div class="col-12 col-lg-6">
                            <p>Male: <?=count(categoryResult("gender", "g", "survey", "s", "gender_id",1))?></p>
                            <p>Female: <?=count(categoryResult("gender", "g", "survey", "s", "gender_id", 2))?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    include_once "includes/footer.php";
?>