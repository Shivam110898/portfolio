<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.delivery.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Add Delivery Cost</h1>
                </div>
                <div class="login">
                    <form method="post" id="CreateDelivery" enctype="multipart/form-data">
                    <input type="text" name="delivery_cost" placeholder="Enter delivery cost" required>
                    <input type="text" name="delivery_desc" placeholder="Enter delivery description" >
                        <input type="submit" onclick="return CreateDelivery()" value="Save">
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