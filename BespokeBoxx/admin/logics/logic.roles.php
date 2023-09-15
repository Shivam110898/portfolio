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
    $update_cat = $db->query('update user_type set status = ? where id = ?', $status, $id);

    echo "toggleRole";
}
// DELETE

if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    // sql to delete a record
    $deleteProducts = $db->query('update user_type set is_deleted = ? where id = ?', '1', $id);
    echo "roledel";
}

// CREATE
if (isset($_POST['role']) ) {
    $role = FormatInput($_POST['role']);

    $selp = $db->query('SELECT * FROM user_type where is_deleted = ? and role = ?', '0', $role)->fetchArray();

    if (count($selp) > 0) {
        echo "exists";
	} else {
        $insert = $db->query('INSERT INTO user_type (role) values (?)', $role);
        if ($insert->affectedRows() > 0) {
            echo "inserted";
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
    $roleid = FormatInput($_GET['id']);
    $fetchedrole= $db->query('SELECT * FROM user_type where id =?', $roleid)->fetchArray();
    }

if (isset($_POST['urole']) && isset($_POST['urole'])){
    $roleId = FormatInput($_POST['roleId']);
    $role = FormatInput($_POST['urole']);
    $selectrole = $db->query('SELECT * FROM user_type where is_deleted = ? and role = ?', '0', $role)->fetchArray();

    if (count($selectrole) > 0) {
        echo "exists";
	} else {
        $update = $db->query('UPDATE user_type SET role=? WHERE id = ?',$role, $userId);
        if ($update->affectedRows() > 0) {
            echo "updated";
        }
            
    }
}