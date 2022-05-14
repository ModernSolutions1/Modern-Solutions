<?php

    if(!isset($_SESSION['user'])){
        $_SESSION['not-logged-in'] = "<div class='message-failed'>Please log in first </div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>