<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

if (isset($_POST['email'])) {
	$email = FormatInput($_POST['email']);
	$password = FormatInput($_POST['password']);	
	$rememberme = $_POST['rememberme'];	
	$CustomerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Customer')->fetchArray();
	$CurrentUser = $db->query('SELECT id,password,user_type_id FROM user WHERE email = ? AND user_type_id = ? AND status = ? AND is_deleted = ?', $email, $CustomerUser['id'], '1', '0')->fetchArray();
	$passwordCheck = password_verify($password, $CurrentUser["password"]);
    $currentDate=date("Y-m-d H:i:s");

	if (count($CurrentUser) > 0 && $passwordCheck) {
	    if($CurrentUser['user_type_id'] == $CustomerUser['id']){
			$_SESSION['CUSTOMER_LOGIN'] = $email;
			$_SESSION['LAST_ACTIVITY'] = time();
			$updateLastLogin = $db->query("UPDATE user SET last_login='$currentDate' WHERE email='$email' AND user_type_id='".$CurrentUser['user_type_id']."'");
			echo "customer";
		}
	} else {
		echo "error";
	}
}

if (isset($_POST['txtemail'])) {
	$email = FormatInput($_POST['txtemail']);
	$firstname = FormatInput($_POST['txtfirstname']);
	$lastname = FormatInput($_POST['txtlastname']);
	$password = FormatInput($_POST['txtpassword']);
	$confirmpassword = FormatInput($_POST['txtconfirmpassword']);
    $currentDate=date("Y-m-d H:i:s");

	$CustomerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Customer')->fetchArray();
	$selectusers = $db->query('SELECT id FROM user WHERE email = ? AND user_type_id = ? AND status = ? AND is_deleted = ?', $email, $CustomerUser['id'], '1', '0')->fetchArray();
	if ($password != $confirmpassword) {
		echo "notmatch";
	} else if (count($selectusers) > 0) {
		echo "exists";
	} else {
		$insert = $db->query('INSERT INTO user (email, first_name, last_name, password, user_type_id, token, status,created_at) values (?,?,?,?,?,?,?,?)',$email,$firstname,$lastname, password_hash($confirmpassword, PASSWORD_DEFAULT), $CustomerUser['id'],md5(uniqid($email)), '1',$currentDate);
        if ($insert->affectedRows() > 0) {
			ob_start();
			include $root.'/logics/accountCreateEmail.php';
			$body = ob_get_clean();
			send_mail($email,'info@bespokeboxx.co.uk',"Account Created","$body");
            echo "inserted";
        } else {
            echo"failed";
        }

	}
}

if (isset($_POST['recoverytoken'])) {
	$token = $_POST['recoverytoken'];
	$password = $_POST['recoverypassword'];
	$confirmPassword = $_POST['recoveryconfirmpassword'];
	$existingPassword = $db->query('SELECT password FROM user WHERE token = ? ', $token)->fetchArray();

	if ($password != $confirmPassword) {
		echo "notmatch";
	} else if (password_verify($confirmPassword, $existingPassword["password"])) {
		echo "exists";
	} else {
		$confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
		$updatePassword = $db->query('update user set password = ? where token = ?', $confirmPassword, $token);
		echo "success";
	}
}

if(isset($_POST['guestLoginEmail'])){
    $email = FormatInput($_POST['guestLoginEmail']);
	$CustomerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Customer')->fetchArray();
	$GuestUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Guest')->fetchArray();
	$existingCustomer = $db->query('SELECT email from user WHERE user_type_id = ? AND email=? and is_deleted = ? and status = ?', $CustomerUser['id'], $email, 0, 1)->fetchArray();
    $currentDate=date("Y-m-d H:i:s");

	if (count($existingCustomer) > 0) {
		echo "exists";
	} else {
		$insert = $db->query('INSERT INTO user (email, user_type_id, token, status,created_at) values (?,?,?,?,?)',
		$email, $GuestUser['id'], md5(uniqid($email)), '1',$currentDate);
        if ($insert->affectedRows() > 0) {
			$_SESSION['GUEST_LOGIN'] = $db->lastInsertID();
            echo "inserted";
        } else {
            echo $db->error($insert);
        }
	}

}

//delete account
if (isset($_GET['deleteEmail'])){
	if($_GET['deleteEmail']=='YES'){
		$deleteEmail = $_SESSION['CUSTOMER_LOGIN'];
		RightToForget($deleteEmail, $db);
		clearCart();
		unset($_SESSION['CUSTOMER_LOGIN']);
		echo "accountDeleted";
	}

}
