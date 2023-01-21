<?php
    if(isset($_SESSION['user'])):
        if($_SESSION['user']->role_id == 1):
            $user = $_SESSION['user'];
            $allUssers = selectAll("users");
?>


<div class="container py-5">
        <h2 class="text-center">Users</h2>
    <div class="row mt-3">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date joined</th>
                    <th scope="col">Active</th>
                    <th scope="col">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allUssers as $u):?>
                    <?php if($u->user_id == $user->user_id) continue;?>
                <tr>
                    <input type="hidden" id="idUserToChange" value="<?=$u->user_id?>" />
                    <th scope="row"><?=$u->name?> <?=$u->last_name?></th>
                    <td><?=$u->email?></td>
                    <td><?=$u->date?></td>
                    <td>
                        <select class="form-select form-select-sm status" data-type="active" aria-label=".form-select-sm example">
                            <?php if($u->active == 0):?>
                            <option selected value="0">Enabled</option>
                            <option value="1">Disabled</option>
                            <?php else:?>
                            <option value="0">Enabled</option>
                            <option selected value="1">Disabled</option>
                            <?php endif?>
                            
                        </select>
                    </td>
                    <td>
                        <select class="form-select form-select-sm status" data-type="role_id" aria-label=".form-select-sm example">
                            <?php if($u->role_id == 1):?>
                            <option selected value="1">Admin</option>
                            <option value="2">User</option>
                            <?php else:?>
                            <option value="1">Admin</option>
                            <option selected value="2">User</option>
                            <?php endif?>
                        </select>
                    </td>
                </tr>
                <?php endforeach?>    
            </tbody>
        </table>
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

