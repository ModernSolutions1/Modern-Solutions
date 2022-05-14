<?php

    if(!isset($_SESSION['authenticated'])){
        header('location:'.SITEURL.'login.php');
    }
?>