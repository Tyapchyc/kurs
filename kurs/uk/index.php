<?php session_start();
    $_SESSION['lang'] = "uk";
    header("Location: ".$_SERVER['HTTP_REFERER']); 
?>