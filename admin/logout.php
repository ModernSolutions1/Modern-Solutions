<?php

    include('../config/constants.php');

    unset($_SESSION['user']);
    header('location:'.SITEURL.'admin/login.php');
?>