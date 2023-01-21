<?php 
    session_start();
    include "connection/database.php" ;
    include "models/functions.php" ;
    $social = selectAll("social");
    $categories = selectAll("category");
    include_once("includes/head.php");
    
?>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold">LOGIN</h4>
                </div>
                <div class="bg-white border border-top-0 p-4 mb-3">
                    <form>
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" />

                        <label for="password" class="mt-3">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" />

                        <input type="button" value="Login" class="btn btn-primary font-weight-semi-bold px-4 mt-3" id="login" name="login" />
                        <?php if(isset($_GET['userRegister']) && isset($_GET['unique'])){
                            $userToCheck = getActUser($_GET['userRegister']);
                            if($userToCheck->active == 0 && strtotime($userToCheck->date) == $_GET['unique']){
                                echo "<p class='text-danger'>You have already registered</p>";
                            }
                            else if(strtotime($userToCheck->date) == $_GET['unique']){
                                changeStatus($_GET['userRegister'], 0, "active");
                                echo "<p class='text-success'>You have successfully registered, please log in</p>";
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include_once("includes/footer.php")?>