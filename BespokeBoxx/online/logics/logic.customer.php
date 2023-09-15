<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);


if (isset($_POST['firstname'])){
    $userId= FormatInput($_POST['id']);
    $email = FormatInput($_POST['email']);
	$firstname = FormatInput($_POST['firstname']);
	$lastname = FormatInput($_POST['lastname']);

	$CustomerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Customer')->fetchArray();

    $selectusers = $db->query('SELECT id FROM user WHERE id != ? AND email = ? AND user_type_id = ? AND status = ? AND is_deleted = ?',  $userId, $email, $CustomerUser['id'], '1', '0')->fetchArray();
    if (count($selectusers) > 0) {
		echo "exists";
	} else {
        $insert = $db->query('UPDATE user SET first_name=?, last_name=?,email=? WHERE id = ?', $firstname, $lastname, $email, $userId);
       if ($insert->affectedRows() > 0) {
        $_SESSION['CUSTOMER_LOGIN'] = $email;

           echo "inserted";
       } else echo "failed";
	}	
}

if(isset($_POST['recipient_firstname']) && isset($_POST['recipient_firstname'])) {
    $userId = $_POST['userid'];
    $boxx_id = $_POST['boxx_id'];
    $type = $_POST['type'];
    $recipient_firstname = $_POST['recipient_firstname'];
    $recipient_lastname = $_POST['recipient_lastname'];
    $recipient_number = $_POST['recipient_number'];
    $addressline1 = $_POST['addressline1'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];

    
    $selectaddress = $db->query('SELECT id FROM user_address WHERE user_id = ? AND address_line_1 = ? AND first_name=? AND is_deleted=?',  $userId, $addressline1, $recipient_firstname,'0')->fetchArray();
    if (count($selectaddress) > 0) {
        echo "exists";
    } else {
        $insert = $db->query('INSERT INTO user_address (user_id, first_name, last_name, phone_number, address_line_1,city,post_code) values (?,?,?,?,?,?,?)',
        $userId, $recipient_firstname, $recipient_lastname, $recipient_number,  $addressline1, $city, $postcode);
        if ($insert->affectedRows() > 0) {
            $address_id = $db->lastInsertID();
            if($type =="bespoke"){
                $_SESSION['Cart'][$boxx_id]['delivery_address_id'] = $address_id;

            } else  if($type =="hotm"){
                $_SESSION['botmBoxx'][$boxx_id]['delivery_address_id'] = $address_id;
            }
            echo "inserted";
        }
    }
    
}

// DELETE
if (isset($_GET['Del'])) {
    $id = $_GET['Del'];
    $editAddress = $db->query('UPDATE user_address set is_deleted = ? WHERE id = ?', '1', $id);
    if ($editAddress->affectedRows() > 0) {
        echo "addressDelete";
    }
   

}

//go to EDIT page 
if (isset($_GET['Edit']) ) {
    $edit = FormatInput($_GET['edit']);
    echo "success"; 
}



if (isset($_POST['uaddressline1']) && isset($_POST['urecipient_lastname'])){
    $id= FormatInput($_POST['id']);
    $userId = $_POST['userid'];
    $recipient_firstname = $_POST['urecipient_firstname'];
    $recipient_lastname = $_POST['urecipient_lastname'];
    $recipient_number = $_POST['urecipient_number'];
    $addressline1 = FormatInput($_POST['uaddressline1']);
	$city = FormatInput($_POST['city']);
	$postcode = FormatInput($_POST['postcode']);
    $selectaddress = $db->query('SELECT id FROM user_address WHERE user_id = ? AND address_line_1 = ? AND first_name=? AND is_deleted=?',  $userId,$addressline1,$recipient_firstname,'0')->fetchArray();
    if (count($selectaddress) > 0) {
        echo "exists";
    } else {
        $editAddress = $db->query('UPDATE user_address set first_name=?,last_name=?,phone_number=?,address_line_1=?,  city=?, post_code = ? WHERE id = ?',$recipient_firstname,$recipient_lastname,$recipient_number, $addressline1, $city,$postcode, $id);
        if ($editAddress->affectedRows() >= 0) {
            echo "updatedAddress";
        }
    }
    

}

if (isset($_POST['message_firstname']) && isset($_POST['message_lastname'])){
    $message_firstname = FormatInput($_POST['message_firstname']);
	$message_lastname = FormatInput($_POST['message_lastname']);
	$message_email = FormatInput($_POST['message_email']);
	$message_details = FormatInput($_POST['message_details']);

    if(send_mail("info@bespokeboxx.co.uk", $message_email,"Bespoke/Bulk Inquiry", $message_details)){
        echo "sent";
    }
}
if (isset($_POST['recoveryemail'])){
    $recovery_email = FormatInput($_POST['recoveryemail']);
    $user = $db->query('SELECT token FROM user WHERE email = ? AND user_type_id = ?', $recovery_email, '5')->fetchArray();
    if (count($user) > 0){

        ob_start();
        include $root.'/logics/passwordRecoveryEmail.php';
        $body = ob_get_clean();
        if(send_mail($recovery_email,'info@bespokeboxx.co.uk',"Password Recovery","$body")){
            echo "sent";
        }
    } else {
        echo "notvalid";
    } 
}
