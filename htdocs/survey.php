<?php 
    session_start();
    if(isset($_SESSION['user'])){
        include "connection/database.php";
        include "models/functions.php";
        $social = selectAll("social");
        $categories = selectAll("category");
        include_once "includes/head.php";
        $user = $_SESSION['user'];
    }
    else{
        header("HTTP/1.0 404 Not Found");
    }
    
?>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">SURVEY</h4>
                </div>
                <div class="bg-white border border-top-0 p-4 mb-3">
                    <p>Please fill out this survey, it is anonymus just for statistic research</p>
                    <label class="form-check-label mt-2" for="categorySurvey">
                        Please select your favourite category
                    </label><br/>
                    <select class="form-select" aria-label="Default select example" id="categorySurvey">
                        <option value="0">Select</option>
                        <?php foreach($categories as $c):?>
                        <option value="<?=$c->category_id?>"><?=$c->name?></option>
                        <?php endforeach?>
                    </select>
                    <div class="form-check mt-3">
                        <input class="form-check-input gender" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1" />
                        <label class="form-check-label" for="flexRadioDefault1">
                            Male
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input gender" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2" />
                        <label class="form-check-label" for="flexRadioDefault2" id="second">
                            Female
                        </label>
                    </div>
                    <input type="button" value="Done" id="surveyBtn" class="btn btn-primary my-3" />
                </div>
            </div>
        </div>
    </div>

<?php include_once("includes/footer.php")?>