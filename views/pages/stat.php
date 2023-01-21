<?php
    if(isset($_SESSION['user'])):
        if($_SESSION['user']->role_id == 1):
            $visitors = file("data/pageStat.txt");
            $logins = file("data/login.txt");
            $failed = file("data/errorLog.txt");
            // var_dump(date("G:i:s", time() - 1500));
?>


<div class="container py-5">
        <h2 class="text-center">Page stat</h2>
    <div class="row mt-3">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Page</th>
                    <th>Page traffic in %</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count($visitors) != 0){
                        $pages = [];
                        $traffic = count($visitors);
                        foreach ($visitors as $e) {
                            if (!empty($e)) {
                                $value = explode("\t", $e);
                                $visitor = explode('=', $value[0]);
                                if ($visitor != '') {
                                    if (array_key_exists($visitor[1], $pages)) {
                                        $pages[$visitor[1]]++;
                                    }
                                    else {
                                        $pages[$visitor[1]] = 1;
                                    }
                                }
                            }
                        }
                        foreach ($pages as $key => $val) {
                            $percent = round($val / $traffic * 100);
                            echo "<tr>
                            <th scope='row'>" . $key . "</td>
                            <td>" . $percent . "%</td>
                            <td>" . $val . "</td>
                            </tr>";
                        }
                    }
                    else{
                        echo "<h2 class='text-center mt-5'>There stav currently</h2>";
                    }
                    ?>
            </tbody>
        </table>

        <div class="table-responsive mt-2">
            <h2 class="text-center">Logged user stat</h2>
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Email</th>
                        <th>Date and time</th>
                        <th>IP Address</th>
                        <th>Result Message</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($logins as $log):
                            if(!empty($log)):
                                $logArr = explode("\t", $log);
                    ?>
                    <tr>
                        <td><?=$logArr[0]?></td>
                        <td><?=$logArr[1]?></td>
                        <td><?=$logArr[2]?></td>
                        <td><?=$logArr[3]?></td>
                        <td><?=$logArr[4]?></td>
                            <?php endif?>
                    </tr>        
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
        <div class="table-responsive mt-2">
            <h2 class="text-center">Failed log user stat</h2>
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Email</th>
                        <th>Date and time</th>
                        <th>IP Address</th>
                        <th>Result Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($failed as $f):
                            if(!empty($f)):
                                $failArr = explode("\t", $f);
                    ?>
                    <tr>
                        <td><?=$failArr[0]?></td>
                        <td><?=$failArr[1]?> <?=$failArr[2]?></td>
                        <td><?=$failArr[3]?></td>
                        <td><?=$failArr[4]?></td>
                            <?php endif?>
                    </tr>        
                    <?php endforeach?>
                </tbody>
            </table>
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

