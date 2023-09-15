<?php 
session_start();
$expire = time() - 3600;
unset($_COOKIE['REMEMBER_ME']);
setcookie('REMEMBER_ME', '', $expire,'/');
session_unset();
session_destroy();
header("location: /index.php");

?>