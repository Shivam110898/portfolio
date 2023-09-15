<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);
(new DotEnv($root . '/.env'))->load();

// TOGGLE STATUS
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = FormatInput($_GET['action']);
    $id = FormatInput($_GET['id']);

    if ($action == 'activate') {
        $status = '1';
    } else {
        $status = '0';
    }
    $toggle_product= $db->query('UPDATE products SET status = ? WHERE id = ?', $status, $id);
    echo "toggleProduct";
}

if (isset($_GET['product_id']) && isset($_GET['visOrder'])) {
    $order = FormatInput($_GET['visOrder']);
    $id = FormatInput($_GET['product_id']);

    $toggle_product= $db->query('UPDATE products SET visibility_order = ? WHERE id = ?', $order, $id);
    echo "orderChanged";
}

// DELETE
if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    // sql to delete a record
    $DeleteOldCategories = $db->query('DELETE FROM products_to_category where product_id = ?', $id);
    $deleteproperties = $db->query('DELETE FROM product_properties WHERE product_id = ?', $id);
    $deleteProducts = $db->query('UPDATE products SET is_deleted = ? WHERE id = ?', '1', $id);
    DeleteImagesNotInTheDB($db);
    echo "prodel";
}

// CREATE
if (isset($_POST['name']) && isset($_POST['price']) && $_FILES["userImage"]) {
    $name = FormatInput($_POST['name']);
    $url = $_POST['url'];
    $desc = FormatInput($_POST['desc']);
    $sku = FormatInput($_POST['sku']);
    $cost = FormatInput($_POST['cost']);
    $price = FormatInput($_POST['price']);
    $quantity = FormatInput($_POST['quantity']);
    $uploads_dir = $root . '/uploadedimgs/';
    $Front_uploads_dir = getenv('FRONTEND_IMAGES_DIR');
    $tmp_name = $_FILES["userImage"]["tmp_name"];
    $image = basename($_FILES["userImage"]["name"]);
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $extensions_arr = array('jpg','JPG','jpeg','JPEG','png','PNG','heic', 'HEIC');
    $uniquesavename = CreateGUID() . '.' .  $imageFileType;
    $destFile = $uploads_dir . $uniquesavename;
    $FrontdestFile = $Front_uploads_dir . $uniquesavename;
    $response = null;

    $selp = $db->query('SELECT * FROM products where is_deleted = ? and name = ?', '0', $name)->fetchArray();

    if (count($selp) > 0) {
        echo "exists";
    } else {
        if (in_array($imageFileType, $extensions_arr)) {
            if (copy($tmp_name, $FrontdestFile) && copy($tmp_name, $destFile)) {
                $insert = $db->query('INSERT INTO products (name, url, description, cost, price,SKU, quantity,image,status) 
                values (?,?,?,?,?,?,?,?,?)', $name, $url, $desc, $cost, $price, rand(0000,9999), $quantity, $uniquesavename, '1');
                if ($insert->affectedRows() > 0) {
                    $lastinsertedproductid = $db->lastInsertID();
                    $userData = count($_POST["pname"]);
                    $selectedCategories = count($_POST["category"]);

                    for ($i = 0; $i < $userData; $i++) {
                        if (trim($_POST['pname'] != '') && trim($_POST['pvalue'] != '')) {
                            $pname   = $_POST["pname"][$i];
                            $pvalue  = $_POST["pvalue"][$i];
                            $insertProps = $db->query('INSERT INTO product_properties (property_name,property_value,product_id) 
                            values (?,?,?)', $pname, $pvalue, $lastinsertedproductid);
              
                        }
                    }

                    for ($x = 0; $x < $selectedCategories; $x++) {
                        $category  = $_POST["category"][$x];
                        $insert = $db->query('INSERT INTO products_to_category (product_id,category_id) 
                            values (?,?)', $lastinsertedproductid, $category);
                    }
                    DeleteImagesNotInTheDB($db);
                    cleanseUselessUserData($db);
                    echo "inserted";
                }
            } else {
                echo "failed";
            }
        } else {
            echo "invalid";
        }
    }
}
//go to EDIT page 
if (isset($_GET['Edit'])) {
    $edit = FormatInput($_GET['Edit']);
    echo "success";
}

//populate edit fields with existing value
if (isset($_GET['id'])) {
    $pid = FormatInput($_GET['id']);
    $fetchedcats = $db->query('SELECT * FROM product_category where status=? and is_deleted = ? order by name asc', '1', '0')->fetchAll();
    $fetchedproduct = $db->query('SELECT * FROM products where id = ?', $pid)->fetchArray();
    $fetchedproductprops = $db->query('SELECT * FROM product_properties where product_id = ?', $pid)->fetchAll();
    $assignedCategories = $db->query('SELECT * FROM products_to_category where product_id = ?', $pid)->fetchAll();
}

if (isset($_POST['uname']) && isset($_POST['id']) ){
    $id = FormatInput($_POST['id']);
    $name = FormatInput($_POST['uname']);
    $url = $_POST['uurl'];
    $description = FormatInput($_POST['udesc']);
    $cost = FormatInput($_POST['ucost']);
    $price = FormatInput($_POST['uprice']);
    $quantity = FormatInput($_POST['uquantity']);
        
    $updateproduct = $db->query("UPDATE products SET name=?, url=?, description=?, cost=?, price=?, quantity=? WHERE id = ?", $name, $url, $description,$cost, $price, $quantity, $id);
        
    if ($updateproduct->affectedRows()>=0) {
        $DeleteOldProps = $db->query('DELETE FROM product_properties where product_id = ?', $id);
        $DeleteOldCategories = $db->query('DELETE FROM products_to_category where product_id = ?', $id);
        $userData = count($_POST["pname"]);
        $selectedCategories = count($_POST["category"]);

        for ($i = 0; $i < $userData; $i++) {
            if (trim($_POST['pname'] != '') && trim($_POST['pvalue'] != '')) {
                $pname   = $_POST["pname"][$i];
                $pvalue  = $_POST["pvalue"][$i];
                $insertProps = $db->query('INSERT INTO product_properties (property_name,property_value,product_id) 
                values (?,?,?)', $pname, $pvalue, $id);
            }
        }

        for ($i = 0; $i < $selectedCategories; $i++) {
            $category  = $_POST["category"][$i];
            $insert = $db->query('INSERT INTO products_to_category (product_id,category_id) values (?,?)', $id, $category);
        }
        echo "updated";
    } else {
        echo "failedtoupdate";
    }
    
}

if (isset($_POST['prodId']) && $_FILES["userImage"]){
    $prodId = FormatInput($_POST['prodId']);
    $uploads_dir = $root . '/uploadedimgs/';
    $tmp_name = $_FILES["userImage"]["tmp_name"];
    $image = basename($_FILES["userImage"]["name"]);
    // Select file type
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array('jpg','JPG','jpeg','JPEG','png','PNG','heic', 'HEIC');

    $uniquesavename = CreateGUID() . '.' .  $imageFileType;
    $destFile = $uploads_dir . $uniquesavename;
    $Front_uploads_dir = getenv('FRONTEND_IMAGES_DIR');

    $FrontdestFile = $Front_uploads_dir . $uniquesavename;
    // Check extension
    if (in_array($imageFileType, $extensions_arr)) {
        
        $update = $db->query('UPDATE products SET image = ? WHERE id = ?',   $uniquesavename, $prodId);

        $img =  $root . '/uploadedimgs/' . $row1['image'];
        // Upload file
        copy($tmp_name, $destFile);
        copy($tmp_name, $FrontdestFile);
        if ($update->affectedRows() > 0) {
            DeleteImagesNotInTheDB($db);
            cleanseUselessUserData($db);
            echo "updated";
        } else {
            echo "error";
        }
    } else {
        echo "invalid";
    }
}