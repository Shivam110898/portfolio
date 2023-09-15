<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.discount.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
$discountGroups = array('COMPETITION', 'PROMO'); 
$discountTypes = array('%TAGE', 'AMOUNT'); 
?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Add Discount</h1>
                </div>
                <div class="login">
                    <form method="post" id="CreateDiscount" enctype="multipart/form-data">
                        <select  name="discount_group" class="form-control" data-role="select-dropdown" data-profile="minimal">
                            <?php 
                            foreach ($discountGroups as $row) {
                                echo '<option value="' . FormatInput($row) . '">'. FormatInput($row) . '</option>';
                            } ?>
                        </select>
                        <input type="text" name="description" placeholder="Enter description" required>
                        <select  name="discount_type" class="form-control" data-role="select-dropdown" data-profile="minimal">
                            <?php 
                            foreach ($discountTypes as $row) {
                                echo '<option value="' . FormatInput($row) . '">'. FormatInput($row) . '</option>';
                            } ?>
                        </select>
                        <input type="text" name="discount_value" placeholder="Enter discount value" required>
                        <input type="text" name="min_total" placeholder="Enter minimum subtotal for discount to be valid" required>
                        <input type="datetime-local" name="expiry">
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