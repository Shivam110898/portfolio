<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];




include_once $root . "/logics/logic.delivery.php";
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
<script type="text/javascript">
    $(document).ready(function () {
        LoadDelivery();
        $('#search_text').keyup(function () {
            var search = $(this).val();
            if (search != '') {
                LoadDelivery(search);
            } else {
                LoadDelivery();
            }
        });
    });
</script>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">

            <div class="col-sm-2">
                <div class="page-header">
                    <h1>Delivery</h1>
                </div>
            </div>
            <div class="col-sm-2">
                <br />

                <a href="/create/delivery_create.php" class="button" role="button">Add Delivery</a>
            </div>
            <div class="col-sm-5">
                <br />

                <input type="text" name="search_text" id="search_text" placeholder="Search" class="form-control" />
            </div>
            <div class="col-sm-12">

                <div id="result"></div>

            </div>
        </div>
    </div>
</div>


<?php
include_once $root . "/layouts/footer.php";
?>