<?php
    session_start();
    
    //session_destroy();
    unset($_SESSION['adminName']);
    
    header("Location:adminLogin.php")
?>