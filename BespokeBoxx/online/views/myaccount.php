<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

if (!isset($_SESSION["CUSTOMER_LOGIN"]) || $_SESSION["CUSTOMER_LOGIN"] === '') {
    header("location: /views/logout.php");
    exit;
}

$profileResult = $db->query('SELECT * FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();

include_once $root . "/views/header.php";
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Welcome back, <?= $profileResult['first_name'] ?>. </div>
            </div>
            <div class="col-md-8">
                <p class="site-section-sub-heading"># RECENT ORDERS </p>

                <?php  
                $ordersResult = $db->query('SELECT * FROM order_details where user_id = ? ORDER BY created_at desc LIMIT 2', $profileResult['id'] )->fetchAll();
                if (count($ordersResult) > 0) {
                ?>
                <div class='table-responsive'>
                    <table class='table table-borderless table-hover'>
                        <thead>
                            <tr>
                                <th>Ordered Date</th>
                                <th>Order #</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ( $ordersResult as $row) {
                            ?>
                                        <tr>
                                            <td><?php echo $row['created_at']; ?></td>
                                            <td><?php echo $row['order_no']; ?></td>
                                            <td>£<?php echo $row['total']; ?></td>
                                            <td> <?php
                                        if ($row['status'] == 1) {
                                            
                                            echo "<a href='/views/myorder_details.php?order_no=".$row['order_no']."' class='icons-btn d-inline-block'>DISPATCHED</span></a>";
                                        } else { 
                                            echo "<a href='/views/myorder_details.php?order_no=".$row['order_no']."' class='icons-btn d-inline-block'>PREPARING</span></a>";
                                        
                                        }
                                    ?>

                                            </td>
                                        </tr>
                                        <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <div class='table-responsive'>
                    <p class='lead'><em>You have no orders.</em></p>
                </div>
                <?php }?>
                <p class="site-section-sub-heading"># Addresses </p>

                <?php  
                $ordersResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted= ? ORDER BY created_at desc LIMIT 2', $profileResult['id'],0 )->fetchAll();
                if (count($ordersResult) > 0) {
                ?>
                <div class='table-responsive'>
                    <table class='table table-borderless table-hover'>
                        <thead>
                            <tr>
                                <th>Address Line 1</th>
                                <th>Address Line 2</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        foreach ( $ordersResult as $row) {
                        ?>
                            <tr>
                                <td><?php echo $row['address_line_1']; ?></td>
                                <td><?php echo $row['address_line_2']; ?></td>
                                <td><?php echo $row['city']; ?></td>
                                <td><?php echo $row['post_code']; ?></td>
                                <td><?php if( $row['is_delivery']=='1'){
                                            echo "Yes";
                                        } else {
                                            echo "No";
                                        }
                                        ?></td>
                                <td><a href="/views/myaddress.php" class="icons-btn d-inline-block">View</span></a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                <div class='table-responsive'>

                    <p class='lead'><em>You have no addresses saved.</em></p>
                </div>

                <?php }?>
            </div>
            <div class="col-md-4 ml-auto">
                <?php include_once $root . "/views/customermenu.php";?>

            </div>
        </div>
    </div>
</div>


<?php

    include_once $root . "/views/footer.php";
    ?>