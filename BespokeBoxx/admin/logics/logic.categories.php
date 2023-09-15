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
    $update_cat= $db->query('UPDATE product_category set status = ? where id = ?', $status, $id);
    
    // $product_category = $db->query('SELECT * FROM products_to_category where category_id = ?', $id)->fetchAll();
    // foreach ($product_category as $pc) {
    //     $relatedproducts = $db->query('SELECT * FROM products where id = ?', $pc['product_id'])->fetchAll();
    //     foreach ($relatedproducts as $product) {
    //         $update_pro = $db->query('UPDATE products set status = ? where id = ?', $status, $product['id']); 

    //     }    
    // }
    echo "toggleCategory";

}
// DELETE

if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    // sql to delete a record
    $relatedproducts = $db->query('SELECT * FROM product_category where name = ?', $id)->fetchAll();
    $cnt =  count($relatedproducts);
    if ($cnt > 0) {
        $deleteCategory = $db->query('update product_category set is_deleted = ? where id = ?', '1', $id);
        foreach ($relatedproducts as $product) {
            $deleteProducts = $db->query('update products set is_deleted = ? where id = ?', '1', $product['id']);
        }
        echo "catdel";

    } else{
        $deleteCategory = $db->query('update product_category set is_deleted = ? where id = ?', '1', $id);
        echo "catdel";

    }
}

// CREATE
if(isset($_POST['name']) && isset($_POST['description'])){
    $name = FormatInput($_POST['name']);
    $description = FormatInput($_POST['description']);
    $selcat = $db->query('SELECT * FROM product_category where is_deleted = ? and name = ?', '0',$name)->fetchArray();

    if (count($selcat) > 0) {
        echo "exists";
    } else{
        $insert = $db->query('INSERT INTO product_category (name, description, status) values (?,?,?)', $name,$description, '1');
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
    $fetchedcategory = $db->query('SELECT * FROM product_category where id = ?', $id)->fetchArray();
}

//update the category
if(isset($_POST['uname'])){
    $catId = FormatInput($_POST['catId']);
    $name = FormatInput($_POST['uname']);
    $description = FormatInput($_POST['udescription']);
    $editCategory = $db->query('UPDATE product_category set name = ?, description = ? where id = ?', $name,$description, $catId);
    echo "updatedcat";

}

?>