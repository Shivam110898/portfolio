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
    $update_cat= $db->query('UPDATE hamper_of_the_month set status = ? where id = ?', $status, $id);   
    echo "toggleHOTMItem";

}

// CREATE
if(isset($_POST['name']) && isset($_POST['description'])){
    $name = FormatInput($_POST['name']);
    $description = FormatInput($_POST['description']);
    $discount_percent = FormatInput($_POST['discount_percent']);
    $selcat = $db->query('SELECT * FROM discount where is_deleted = ? and description = ?', '0',$description)->fetchArray();

    if (count($selcat) > 0) {
        echo "exists";
    } else{
        $insert = $db->query('INSERT INTO discount (description, discount_percent, status) values (?,?,?)', $description,$discount_percent, '1');
        if ($insert->affectedRows() > 0) {
            echo "inserted";
        } else {
            echo"failed";
        }
    }

}
// DELETE
if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    // sql to delete a record
    $relatedproducts = $db->query('SELECT * FROM hamper_of_the_month where id = ?', $id)->fetchAll();
    $cnt =  count($relatedproducts);
    if ($cnt > 0) {
        $deleteCategory = $db->query('DELETE FROM hamper_of_the_month where id = ?', $id);
        echo "hotmDel";

    } 
}


?>