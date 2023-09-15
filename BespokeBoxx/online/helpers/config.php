<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/logics/DotEnv.php";

(new DotEnv($root . '/.env'))->load();

$host =  getenv('HOST');
$db = getenv('DB');
$user = getenv('USERNAME');
$password = getenv('PASSWORD');
date_default_timezone_set("Europe/London");

?>