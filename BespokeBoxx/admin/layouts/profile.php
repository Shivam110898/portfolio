<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

// Check if the user is logged in, if not then redirect to login page
if(isset($_COOKIE['REMEMBER_ME'])) {
    // Decrypt cookie variable value
    $userid=decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser=$db->query('select * from admin_user where email = ?', $userid)->fetchAll();

    $count=count($getuser);

    if($count > 0) {
        $_SESSION['USER']=$userid;
    }
} else if(!isset($_COOKIE['REMEMBER_ME']) && !isset($_SESSION['USER'])) {
    header("location: /layouts/logout.php");
}


$profileResult = $db->query('SELECT * FROM admin_user where email = ?', $_SESSION['USER'])->fetchArray();

include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row">
            <div class="adminForm">
                <div class="page-header mb-4">
                        <h1 class="mb-4" >Profile</h1>
                            <?php 
                                $userloggedin = $_SESSION['USER'];
                                $userRole = $db->query('SELECT * FROM admin_user WHERE email = ?', $userloggedin)->fetchArray();
                                $EngineerUser = $db->query('SELECT id FROM user_type WHERE role = ?', 'Engineer')->fetchArray();
                                if ($userRole['user_type_id'] ==  $EngineerUser['id']) {
                                    ?>
                                    <!-- <a href="/helpers/test.php?action=test" class="button" role="button">Execute Test Script</a>
                                    <a href="/helpers/test.php?action=replenish" class="button" role="button">Replenish Test Stock</a>
                                    <a href="/helpers/test.php?action=cleanse" class="button" role="button">Cleanse Test Data</a> -->
                                    <?php 
                                }
                            ?>
                </div>
                <div class="login" >
                    <div>
                        <p>Your account details are below:</p>
                        <div class="table-responsive">
                            <table class='table table-borderless table-hover'>
                                <tr> 
                                    <td>Username:</td>
                                    <td><?= $profileResult['user_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>First name:</td>
                                    <td><?= $profileResult['first_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Last name:</td>
                                    <td><?= $profileResult['last_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td  style="max-width:30px;"><?= $profileResult['email'] ?></td>
                                </tr>
                                <tr>
                                    <td>Phone Number:</td>
                                    <td  style="max-width:30px;"><?= $profileResult['phone_number'] ?></td>
                                </tr>
                                <tr>
                                    <td>Registered At:</td>
                                    <td><?=  date("d/m/Y H:i:s", strtotime($profileResult['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Last Login:</td>
                                    <td><?= date("d/m/Y H:i:s", strtotime($profileResult['last_login'])) ?></td>
                                </tr>
                            </table>
                        </div>
                        <a href="/edit/password_edit.php?id=<?php echo $profileResult['id']; ?>"class="button" role="button" ><span class="fas fa-pencil-alt"></span> Change Password</a>
                    </div>  
                </div>
                <br />
            </div>
        </div>
    </div>
</div>

    <?php

    include_once $root . "/layouts/footer.php";
    ?>