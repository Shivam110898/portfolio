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


include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="page-header">
            <h1>Manage Front-End Elements</h1>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div id="result">
                    <script type="text/javascript">
                        $(document).ready(function () {
                            LoadHOTMItems();
                        });
                    </script>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>