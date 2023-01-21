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
                                    $up = ($_GET['unique'] + 150);
                                    $down = ($_GET['unique'] - 150);
                                    $registerDate = strtotime($userToCheck->date);
                                    if($userToCheck->active == 0 && $registerDate > $down && $registerDate < $up){
                                        echo "<p class='text-danger'>You have already registered</p>";
                                    }
                                    else if($registerDate > $down && $registerDate < $up){
                                        changeStatus($_GET['userRegister'], 0, "active");
                                        echo "<p class='text-success'>You have successfully registered, please log in</p>";
                                    }
                                }
                                else if(isset($_GET['lockAcc']) && isset($_GET['lock'])){
                                    $userToCheck = getActUser($_GET['lockAcc']);
                                    $lock = $_GET['lock'];
                                    if($userToCheck->active == 1 && $lock == md5("lock")){
                                        changeStatus($_GET['lockAcc'], 0, "active");
                                        echo "<p class='text-success'>You activated your account</p>";
                                    }
                                }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>