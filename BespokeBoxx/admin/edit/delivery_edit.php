<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.categories.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
//populate edit fields with existing value
if(isset($_GET['id'])){
    $id = FormatInput($_GET['id']); 
    $fetchedDelivery = $db->query('SELECT * FROM delivery where id = ?', $id)->fetchArray();
}
?>
<div class="container-fluid">
    <div class="maincontent">
    <div class="row ">

    <div class="adminForm">
            <div class="page-header mb-4">
            <h1>Edit Delivery</h1>
            </div>
            <div class="login" >
            <form  method="post" id="UpdateDelivery" enctype="multipart/form-data">
            <input id="deliveryId" name="deliveryId" type="hidden" value="<?php echo $fetchedDelivery['id']; ?>">       
            <input type="text" id="udelivery_cost" name="uname" value="<?php echo $fetchedDelivery['delivery_cost']; ?>" required>
            <input type="text" id="udelivery_desc" name="uname" value="<?php echo $fetchedDelivery['description']; ?>" >
                <input type="submit" onclick="return UpdateDelivery()" value="Save">
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