<?php

    include('config/constants.php');
    
    unset($_SESSION['authenticated']);

    header('location:'.SITEURL.'index.php');
?>