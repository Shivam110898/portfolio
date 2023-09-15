<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];



include_once $root . "/logics/logic.users.php";

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
    <div class="row ">

        <div class="col-sm-12">
            <div class="page-header mb-4">
                <h1 class="mb-4" >User Roles</h1>

            </div>
            <div class="login" style="padding:0px;margin:0px;">
                <input type="text" name="search_text" id="search_text" placeholder="Search" class="form-control" />
            </div>
            <br />

            <div id="result"></div>
            <script type="text/javascript">
                $(document).ready(function() {
                    LoadRoles();
                    $('#search_text').keyup(function() {
                        var search = $(this).val();
                        if (search != '') {
                            LoadRoles(search);
                        } else {
                            LoadRoles();
                        }
                    });
                });
            </script>
        </div>
        </div>
    </div>
</div>

<?php
include_once $root . "/layouts/footer.php";
?>