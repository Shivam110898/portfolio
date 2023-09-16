<?php 
session_start();
unset($_SESSION['CUSTOMER_LOGIN']);
header("location: /views/login.php");
exit;
?>