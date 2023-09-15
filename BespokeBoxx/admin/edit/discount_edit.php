<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.discount.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
$discountTypes = array('%TAGE', 'AMOUNT'); 
$discountGroups = array('COMPETITION', 'PROMO'); 

?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Edit Discount</h1>
                </div>
                <div class="login">
                    <form method="post" id="UpdateDiscount" enctype="multipart/form-data">
                        <input id="discountId" name="discountId" type="hidden" value="<?php echo $fetchedDiscount['id']; ?>">
                        <select  name="udiscount_group" class="form-control" data-role="select-dropdown" data-profile="minimal">
                            <?php 
                            foreach ($discountGroups as $row) {
                                echo '<option value="' . FormatInput($row) . '">'. FormatInput($row) . '</option>';
                            } ?>
                        </select>
                        <input type="text" name="udescription" value="<?php echo $fetchedDiscount['description']; ?>" required>
                        <select name="udiscount_type" class="form-control" data-role="select-dropdown" data-profile="minimal">
                            <?php 
                                foreach ($discountTypes as $row) {
                                    echo '<option value="' . FormatInput($row) . '">'. FormatInput($row) . '</option>';
                                } 
                            ?>
                        </select>
                        <input type="text" name="udiscount_value" value="<?php echo $fetchedDiscount['discount_value']; ?>" required>
                        <input type="text" name="umin_total" value="<?php echo $fetchedDiscount['minimum_total']; ?>" required>
                        <input type="datetime-local"  class="date" name="uexpiry" required>
                        <input type="submit" onclick="return UpdateDiscount()" value="Save">
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