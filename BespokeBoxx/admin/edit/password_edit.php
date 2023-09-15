<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.authenticate.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";

?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">

            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Change Password</h1>
                </div>
                <div class="login">
                    <form action="" onsubmit="return ChangePassword();" method="post">
                        <input type="password" name="password" id="password" value="" placeholder="Enter Password"
                            required>
                        <input type="password" name="confirmPassword" id="confirmPassword" value=""
                            placeholder="Confirm Password" required>
                        <input type="submit" name="save" value="Save">
                    </form>
                </div>
                <br />
            </div>

        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>