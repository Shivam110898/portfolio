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
    $orderDetails = $db->query('SELECT user_id FROM order_details where id = ?', $id)->fetchArray();
    $orderedBy = $db->query('SELECT email FROM user where id = ?', $orderDetails['user_id'])->fetchArray();
    $currentDate=date("Y-m-d H:i:s");

    if ($action == 'pending') {
        $status = '0';
    }else if ($action == 'dispatched'){
        ob_start();
        include $root.'/logics/orderDispatchEmail.php';
        $body = ob_get_clean();
        send_mail($orderedBy["email"],'orders@bespokeboxx.co.uk',"Order Dispatched","$body");
        send_mail('orders@bespokeboxx.co.uk','orders@bespokeboxx.co.uk',"Order Dispatched","$body");
        $status = '1';
        $update_cat = $db->query('update order_details set status = ?, dispatched_at=? where id = ?', $status,$currentDate, $id);

    } else if ($action == 'cancel') {
        $status = '2';
        ob_start();
        include $root.'/logics/orderCancelEmail.php';
        $body = ob_get_clean();
        send_mail($orderedBy["email"],'orders@bespokeboxx.co.uk',"Order Cancelled","$body");
        send_mail('orders@bespokeboxx.co.uk','orders@bespokeboxx.co.uk',"Order Cancelled","$body");
        $update_cat = $db->query('update order_details set status = ?, cancelled_at=? where id = ?', $status,$currentDate, $id);

    }

    echo "toggleOrder";
}
// DELETE

// if (isset($_GET['Del'])) {
//     $id = $_GET['Del'];
//     // sql to delete a record
//     $deleteProducts = $db->query('update order_details set is_deleted = ? where id = ?', '1', $id);
//     echo "orderdel";
// }

// //go to EDIT page 
// if (isset($_GET['Edit'])) {
//     $edit = FormatInput($_GET['Edit']);
//     echo "success";
// }

// //populate edit fields with existing value
// if (isset($_GET['id'])) {
//     $uid = FormatInput($_GET['id']);
//     $fetchedcustomer= $db->query('SELECT * FROM user where id =?', $uid)->fetchArray();
//     $fetchedroles = $db->query('SELECT * FROM user_type where id =? ', '5')->fetchArray();
//     $roleid = $db->query('SELECT user_type_id FROM user where id = ?', $uid)->fetchArray();
// }

// if (isset($_POST['uusername']) && isset($_POST['urole'])){
//     $userId = FormatInput($_POST['userId']);

//     $role = FormatInput($_POST['urole']);
//     $username = FormatInput($_POST['uusername']);
//     $firstname = FormatInput($_POST['firstname']);
//     $lastname = FormatInput($_POST['lastname']);
//     $email = FormatInput($_POST['email']);
//     $phone_number = FormatInput($_POST['phone_number']);
//     $password = FormatInput($_POST['password']);
//     $confirmPassword = FormatInput($_POST['confirmpassword']);
//     $selectrole = $db->query('SELECT id FROM user_type where role = ?' ,$role)->fetchArray();
//     $selectusers = $db->query('SELECT * FROM user where user_type_id = ? and is_deleted = ? and user_name = ?', $selectrole['id'],'0',$username)->fetchArray();

//     if (count($selectusers) > 0) {
//         echo "exists";
//     } else if ($password != $confirmPassword) {
// 		echo "notmatch";
// 	} else {
//                 $selcats = $db->query('SELECT id FROM user_type where role = ?', $role)->fetchArray();
//                 $rid = $selcats['id'];
//                 $insert = $db->query('UPDATE user SET user_type_id=?, user_name=?, first_name=?, last_name=?,email=?,phone_number=?,password=? WHERE id = ?',
//                  $rid, $username, $firstname, $lastname, $email, $phone_number, password_hash($confirmPassword, PASSWORD_DEFAULT), $userId);
//                 if ($insert->affectedRows() > 0) {
//                     echo "updated";
//                 }
            
//     }
// }
