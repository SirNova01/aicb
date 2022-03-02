<?php 
    session_start();
    session_destroy();
    unset($_SESSION['user_role']);
    header("location: ../home.php");
?>