<?php
    require './configuration/connection.php';
?>

<?php 
    $md5Pass = md5("Accessme@123");
    echo $md5Pass;
    
?>