<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

// Check if the user is logged in, if not then redirect to login page
if(isset($_COOKIE['REMEMBER_ME'])) {
    // Decrypt cookie variable value
    $userid=decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser=$db->query('select * from admin_user where email = ?', $userid)->fetchAll();

    $count=count($getuser);

    if($count > 0) {
        $_SESSION['USER']=$userid;
    }
} else if(!isset($_COOKIE['REMEMBER_ME']) && !isset($_SESSION['USER'])) {
    header("location: /layouts/logout.php");
}

if(isset($_GET['action'])){
    $action = FormatInput($_GET['action']);
    if($action == 'replenish'){
        ReplenishTestDataStock($db);
        AlertMessage("Stock Replenished");
    }
    if($action == 'cleanse'){
        CleanseTestData($db);
        AlertMessage("Test DataBase Cleansed");
    }
}

?>