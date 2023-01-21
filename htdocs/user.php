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

<div class="container py-5">
        <h2 class="text-center">Hello <?=$user->name?></h2>
    <div class="row mt-3">
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-12 d-flex justify-content-center mb-3">
                    <div id="user-settings">
                        <img src="img/<?=$user->src?>" alt="<?=$user->alt?>" class="m-auto img-fluid" />
                    </div>
                </div>
                <div class="m-auto col-12 d-flex justify-content-center">
                    <form action="models/photo-manipulation.php" method="post" enctype="multipart/form-data">
                        <input type="submit" value="Change photo" class="btn btn-success btn-sm rounded m-3" name="changePhotoBtn" />
                        <input type="hidden" name="imgSrc" value="<?=$user->src?>" />
                        <input type="file" class="bg-transparent mt-2 mt-lg-0 form-control-sm rounded" name="changePhoto" />
                        <input type="submit" value="Remove photo" class="btn btn-danger btn-sm rounded mx-3" name="deletePhoto" />
                    </form>
                </div>
                    <?php if(isset($_SESSION['profileTypeError'])){
                            echo "<p class='text-danger mb-0'>".$_SESSION['profileTypeError']."</p>";
                            unset($_SESSION['profileTypeError']);
                        }
                    ?>
                    <p class="mt-2">If you remove or change your profile picture you will be logged out, please log in again to see your picture</p>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-4 mt-md-0">
            <div class="section-title mb-0">
                <h4 class="m-0 text-uppercase font-weight-bold">Your account</h4>
            </div>
            <div class="bg-white border border-top-0 p-4 text-center">
                <p class="text-secondary"><span class="font-weight-bold">Full name:</span> <?=$user->name?> <?=$user->last_name?></p>
                <p class="text-secondary"><span class="font-weight-bold">Email:</span> <?=$user->email?></p>
                <p class="text-secondary"><span class="font-weight-bold">Date joined:</span> <?=date("l, j M Y", strtotime($user->date))?></p>
                <p class="text-secondary" id="ptp" data-id="<?=$user->user_id?>"><span class="font-weight-bold">Change passwrod</p>
            </div>
        </div>
    </div>
</div>
    


<?php
    include_once "includes/footer.php";
?>
