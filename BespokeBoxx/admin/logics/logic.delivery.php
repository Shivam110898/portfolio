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
    $update_cat= $db->query('UPDATE delivery set status = ? where id = ?', $status, $id);
       
    echo "toggleDelivery";

}
// DELETE

if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    $deleteCategory = $db->query('delete from delivery where id = ?', $id);
    echo "deliveryDel";
}

// CREATE
if(isset($_POST['delivery_cost'])){
    $delivery_cost = FormatInput($_POST['delivery_cost']);
    $delivery_desc = FormatInput($_POST['delivery_desc']);
    $selcat = $db->query('SELECT * FROM delivery where  delivery_cost = ? AND description = ?',$delivery_cost,$delivery_desc)->fetchArray();

    if (count($selcat) > 0) {
        echo "exists";
    } else{
        $insert = $db->query('INSERT INTO delivery ( delivery_cost, description, status) values (?,?,?)', $delivery_cost, $delivery_desc, '1');
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



//update the category
if(isset($_POST['udelivery_cost'])){
    $Id = FormatInput($_POST['deliveryId']);
    $delivery_cost = FormatInput($_POST['udelivery_cost']);
    $delivery_desc = FormatInput($_POST['udelivery_desc']);
    $update = $db->query('UPDATE delivery set delivery_cost = ?, description =? where id = ?', $delivery_cost, $delivery_desc, $Id);
    echo "updateddelivery";

}

?>