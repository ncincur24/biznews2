<?php 
    session_start();
    include "connection/database.php";    
    include "models/functions.php";    
    $headline = selectHeadlines();
    $categories = selectAll("category");
    include_once "includes/head.php";
?>

<input type="button" id="klik" />
    <div id="probaDiv"></div>
<?php
    include_once("includes/footer.php");
?>

    