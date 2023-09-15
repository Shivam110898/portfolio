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
    $update_cat = $db->query('update admin_user set status = ? where id = ?', $status, $id);

    echo "toggleUser";
}
// DELETE

if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    // sql to delete a record
    $deleteProducts = $db->query('update admin_user set is_deleted = ? where id = ?', '1', $id);
    echo "userdel";
}

// CREATE
if (isset($_POST['email']) && isset($_POST['firstname'])) {
    $role = FormatInput($_POST['role']);
    $firstname = FormatInput($_POST['firstname']);
    $lastname = FormatInput($_POST['lastname']);
    $email = FormatInput($_POST['email']);
    $phone_number = FormatInput($_POST['phone_number']);
    $password = FormatInput($_POST['password']);
    $confirmPassword = FormatInput($_POST['confirmpassword']);
    $selectrole = $db->query('SELECT id FROM user_type where role = ?' ,$role)->fetchArray();
    $selectusers = $db->query('SELECT * FROM admin_user where user_type_id = ? and is_deleted = ? and email = ?', $selectrole['id'],'0',$email)->fetchArray();

    if (count($selectusers) > 0) {
        echo "exists";
    } else if ($password != $confirmPassword) {
		echo "notmatch";
	} else {
        $selcats = $db->query('SELECT id FROM user_type where role = ?', $role)->fetchArray();
        $rid = $selcats['id'];
        $insert = $db->query('INSERT INTO admin_user (user_type_id, first_name, last_name,email,phone_number,password,status) 
        values (?,?,?,?,?,?,?)', $rid, $firstname, $lastname, $email, $phone_number, password_hash($confirmPassword, PASSWORD_DEFAULT),1);
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
    $uid = FormatInput($_GET['id']);
    $fetcheduser= $db->query('SELECT * FROM admin_user where id =?', $uid)->fetchArray();
    $fetchedroles = $db->query('SELECT * FROM user_type where id !=? and status=? and is_deleted = ? order by role asc', '5', '1', '0')->fetchAll();
    $roleid = $db->query('SELECT user_type_id FROM admin_user where id = ?', $uid)->fetchArray();
    $assignedRole = $db->query('SELECT * FROM user_type where id = ?', $roleid['user_type_id'])->fetchArray();
}

if (isset($_POST['ufirstname']) &&isset($_POST['uemail']) && isset($_POST['urole'])){
    $userId = FormatInput($_POST['userId']);
    $role = FormatInput($_POST['urole']);
    $firstname = FormatInput($_POST['ufirstname']);
    $lastname = FormatInput($_POST['ulastname']);
    $email = FormatInput($_POST['uemail']);
    $phone_number = FormatInput($_POST['uphone_number']);
    $password = FormatInput($_POST['upassword']);
    $confirmPassword = FormatInput($_POST['uconfirmpassword']);
    $selectrole = $db->query('SELECT id FROM user_type where role = ?' ,$role)->fetchArray();
    $roleID = $selectrole['id'];
    $selectusers = $db->query('SELECT * FROM admin_user where id!=? and user_type_id = ? and is_deleted = ? and email = ?',$userId, $selectrole['id'],'0',$email)->fetchArray();

    if (count($selectusers) > 0) {
        echo "exists";
    } else if ($password != $confirmPassword) {
		echo "notmatch";
	} else {
        $insert = $db->query('UPDATE admin_user SET user_type_id=?, first_name=?, last_name=?,email=?,phone_number=? WHERE id = ?', 
        $roleID, $firstname, $lastname, $email, $phone_number, $userId);
       if ($insert->affectedRows() > 0) {
           echo "updated";
       }
            
    }
}
