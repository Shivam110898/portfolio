<?php 
    $userloggedin = $_SESSION["USER"];
    $EngineerUser = $db->query('SELECT * FROM user_type WHERE role = ?', 'Engineer')->fetchArray();
	$AdminUser = $db->query('SELECT * FROM user_type WHERE role = ?', 'Admin')->fetchArray();
	$ReadOnlyUser = $db->query('SELECT * FROM user_type WHERE role = ?', 'ReadOnly')->fetchArray();
	$CustomerUser = $db->query('SELECT * FROM user_type WHERE role = ?', 'Customer')->fetchArray();
	$userloggedin = $db->query('SELECT * FROM admin_user WHERE email = ? AND user_type_id != ? AND status = ? AND is_deleted = ?', $_SESSION['USER'], $CustomerUser['id'], '1', '0')->fetchArray();

?>

<div class="adminmain-header loginSticky">
    <div class="adminheader-wrapper">
        <div class="main-logo">
            <a href="/layouts/dashboard.php"><img src="/images/Logo.png" alt="BespokeBoxx" width="95" /></a>
        </div>
        <nav>
            <ul class="main-menu">
                <li>Hi <?php echo $userloggedin["first_name"]; ?> <a href="/layouts/profile.php"><span class="fa fa-user"></span></a> </li>
                <li><a href="/layouts/logout.php"><span class="fas fa-sign-out-alt"></span></a></li>
            </ul>
        </nav>

    </div>
</div>

<div class="loginSidebar">

    <?php

    if ($userloggedin['user_type_id'] ==  $EngineerUser['id'] ) {
    ?>
    <a href="/layouts/dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="/layouts/orders.php"><i class="fas fa-shopping-basket"></i> Orders</a>
    <a href="/layouts/customers.php"><i class="fas fa-user-friends"></i> Customers</a>
    <a href="/layouts/categories.php"><i class="fas fa-gift"></i> Categories</a>
    <a href="/layouts/products.php"><i class="fas fa-gift"></i> Products</a>
    <a href="/layouts/discounts.php"><i class="fas fa-money"></i> Discounts</a>
    <a href="/layouts/delivery.php"><i class="fas fa-truck"></i> Delivery</a>
    <a href="/layouts/users.php"><i class="fas fa-user"></i> Users</a>
    <?php
    }
    if ($userloggedin['user_type_id'] == $AdminUser['id'] ) {
    ?>
    <a href="/layouts/dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="/layouts/orders.php"><i class="fas fa-shopping-basket"></i> Orders</a>
    <a href="/layouts/customers.php"><i class="fas fa-user-friends"></i> Customers</a>
    <a href="/layouts/categories.php"><i class="fas fa-gift"></i> Categories</a>
    <a href="/layouts/products.php"><i class="fas fa-gift"></i> Products</a>
    <?php
    }
    if ($userloggedin['user_type_id'] == $ReadOnlyUser['id'] ) {
        ?>
    <a href="/layouts/dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <?php
        }
    ?>

</div>