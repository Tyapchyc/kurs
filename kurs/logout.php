<?php session_start();
unset($_SESSION['user_id']);
Header("Location: index.php"); 
?>