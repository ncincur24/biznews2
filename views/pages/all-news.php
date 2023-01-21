<?php 
    $news = allNews2(null, null);
?>

    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-8">
                    <div class="row justify-content-center">
                        <select class="form-select mx-4" aria-label="Default select example" id="filterNews">
                            <option value="0">Categories</option>
                            <?php foreach($categories as $c):?>
                            <option value="<?=$c->category_id?>"><?=$c->name?></option>
                            <?php endforeach?>
                        </select>
                        <select class="form-select mx-4" aria-label="Default select example" id="orderNews">
                            <option value="0">Order by</option>
                            <option value="1">Oldest</option>
                            <option value="2">Newest</option>
                        </select>
                    </div>
                    <div class="row mt-5" id="insert-news">
                        
                    </div>
                </div>
                <?php include_once("views/fixed/sidebar.php")?>                
            </div>
            <ul class="pagination" id="pagination-page">    
                
            </ul>
        </div>
    </div> 
    <!-- News With Sidebar End -->

    