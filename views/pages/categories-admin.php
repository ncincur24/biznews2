<?php 
if(isset($_SESSION['user'])):
        if($_SESSION['user']->role_id == 1):
?>
<div class="container my-5">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <h2 class="text-center">Manage categories</h2>   
                        
                    <a href="models/category-export.php" class="btn btn-sm btn-secondary rounded mt-3">Export categories</a>                     
                        <table class="table table-light mt-4 table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Caterory</th>
                                    <th scope="col">Delete</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach($categories as $c):?>
                                <tr data-id="<?=$c->category_id?>" id="row_<?=$c->category_id?>">
                                    <td><?=$c->name?></td>
                                    <td><input type="button" class="btn btn-sm btn-outline-danger rounded delete-category" value="Delete" /></td>
                                    <td>
                                        <div class="form-row p-0">
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="cat_<?=$c->category_id?>" placeholder="Edit" />
                                            </div>
                                            <div class="col-3">
                                                <input type="button" class="btn btn-sm btn-success rounded edit-category" value="Done" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach?> 
                            </tbody>    
                        </table>   
                    <input type="text" class="form-control w-50" placeholder="Add category" id="add-category-text">    
                    <input type="button" class="btn btn-sm btn-primary rounded mt-3" id="add-category" value="+ Add category" />
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