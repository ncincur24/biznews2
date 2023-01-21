<?php
function error($errors, $name){
    if(isset($errors[$name])){
        echo "<div class='alert alert-danger'>".$errors[$name]."</div>";
    }
    else{
        echo "";
    }
}