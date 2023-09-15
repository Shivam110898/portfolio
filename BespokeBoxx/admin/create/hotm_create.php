<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.hotm.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
                <div class="adminForm">
                    <div class="page-header mb-4">
                        <h1>Add Hamper</h1>
                    </div>
                    <div class="login">
                        <form method="post" id="CreateHamper" enctype="multipart/form-data">
                            <input type="text" name="name" placeholder="Enter hamper display" required>
                            <input type="text" name="description" placeholder="Enter hamper discription" required>
                            <input type="text" name="total" placeholder="Enter hamper total" required>
                            <input type="submit" onclick="return CreateDiscount()" value="Save">
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>

<?php
include_once $root . "/layouts/footer.php";
?>