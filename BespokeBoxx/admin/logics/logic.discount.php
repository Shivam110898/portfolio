<?php 
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

// TOGGLE STATUS
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = FormatInput($_GET['action']);
    $id = FormatInput($_GET['id']);

    if ($action == 'activate') {
        $status = '1';
    } else {
        $status = '0';
    }
    $update_cat= $db->query('UPDATE discount set status = ? where id = ?', $status, $id);
       
    echo "toggleDiscount";

}
// DELETE

if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    $deleteCategory = $db->query('update discount set is_deleted = ? where id = ?', '1', $id);
    echo "discountDel";
}

// CREATE
if(isset($_POST['description']) && isset($_POST['discount_value'])){
    $discount_group = FormatInput($_POST['discount_group']);
    $description = FormatInput($_POST['description']);
    $discount_type = FormatInput($_POST['discount_type']);
    $discount_value = FormatInput($_POST['discount_value']);
    $min_total = FormatInput($_POST['min_total']);
    $expiry = date('Y-m-d H:i:s', strtotime($_POST['expiry']));
    $selcat = $db->query('SELECT * FROM discount where is_deleted = ? and description = ?', '0',$description)->fetchArray();

    if (count($selcat) > 0) {
        echo "exists";
    } else{
        $insert = $db->query('INSERT INTO discount (discount_group,description, discount_value, discount_type, minimum_total, expiry, status) values (?,?,?,?,?,?,?)',$discount_group, $description,$discount_value, $discount_type,$min_total,$expiry, '1');
        if ($insert->affectedRows() > 0) {
            echo "inserted";
        } else {
            echo"failed";
        }
    }

}
//go to EDIT page 
if (isset($_GET['Edit']) ) {
    $edit = FormatInput($_GET['edit']);
    echo "success"; 
}

//populate edit fields with existing value
if(isset($_GET['id'])){
    $id = FormatInput($_GET['id']); 
    $fetchedDiscount = $db->query('SELECT * FROM discount where id = ?', $id)->fetchArray();
}

//update the category
if(isset($_POST['udescription'])){
    $discountId = FormatInput($_POST['discountId']);
    $discount_group = FormatInput($_POST['udiscount_group']);
    $description = FormatInput($_POST['udescription']);
    $discount_type = FormatInput($_POST['udiscount_type']);
    $discount_value = FormatInput($_POST['udiscount_value']);
    $min_total = FormatInput($_POST['umin_total']);
    $expiry = date('Y-m-d H:i:s', strtotime($_POST['uexpiry']));
    $editCategory = $db->query('UPDATE discount set discount_group=?, description = ?, discount_value = ?, discount_type = ?, minimum_total = ?, expiry=? where id = ?', $discount_group, $description,$discount_value, $discount_type,$min_total, $expiry, $discountId);
    echo "updateddiscount";

}

?>