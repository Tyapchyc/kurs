<?php session_start();
    $_SESSION['lang'] = "en";
    header("Location: ".$_SERVER['HTTP_REFERER']); 
?>