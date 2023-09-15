<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

if (isset($_POST['email']) && isset($_POST['password'])) {
	$email = FormatInput($_POST['email']);
	$password = FormatInput($_POST['password']);	
	$rememberme = FormatInput($_POST['rememberme']);	
	$EngineerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Engineer')->fetchArray();
	$AdminUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Admin')->fetchArray();
	$ReadOnlyUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'ReadOnly')->fetchArray();
	$CustomerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Customer')->fetchArray();
	$CurrentUser = $db->query('SELECT * FROM admin_user WHERE email = ? AND status = ? AND is_deleted = ?', $email, '1', '0')->fetchArray();
	$passwordCheck = password_verify($password, $CurrentUser["password"] );
	$currentDate=date("Y-m-d H:i:s");

	if (count($CurrentUser) > 0 && $passwordCheck) {
		$_SESSION['USER'] = $email;
		$updateLastLogin = $db->query("UPDATE admin_user SET last_login='$currentDate' WHERE email='$email' AND user_type_id='".$CurrentUser['user_type_id']."'");
		if($rememberme == '1'){
			// Set cookie variables
			$days = 30;
			$cookieValidTill = time()+ ($days * 24 * 60 * 60 * 1000);
			$value = encryptCookie($email);
			setcookie("REMEMBER_ME",$value,$cookieValidTill,'/');
		}
		echo "admin";

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

	$CustomerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Customer')->fetchArray();
	$selectusers = $db->query('SELECT * FROM admin_user WHERE email = ? AND user_type_id = ? AND status = ? AND is_deleted = ?', $email, $CustomerUser['id'], '1', '0')->fetchArray();
	if ($password != $confirmpassword) {
		echo "notmatch";
	} else if (count($selectusers) > 0) {
		echo "exists";
	} else {
		$insert = $db->query('INSERT INTO admin_user (email, first_name, last_name, password, user_type_id, status) values (?,?,?,?,?,?)',$email,$firstname,$lastname, password_hash($confirmpassword, PASSWORD_DEFAULT), $CustomerUser['id'], '1');
        if ($insert->affectedRows() > 0) {
            echo "inserted";
        } else {
            echo"failed";
        }

	}
}


if (isset($_POST['updatePassword'])) {
	$password = FormatInput($_POST['password']);
	$confirmPassword = FormatInput($_POST['confirmPassword']);
	$query = $db->query('SELECT password FROM admin_user WHERE email = ? ', $_SESSION['USER'])->fetchArray();

	if ($password != $confirmPassword) {
		echo "notmatch";
	} else if (password_verify($confirmPassword, $query["password"])) {
		echo "exists";
	} else {
		$confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
		$updatePassword = $db->query('update admin_user set password = ? where email = ?', $confirmPassword, $_SESSION['USER']);
		echo "success";
	}
}
