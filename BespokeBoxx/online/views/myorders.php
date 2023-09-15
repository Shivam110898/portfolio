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
                <div class="site-section-heading">Your Orders</div>
            </div>
            <div class="col-md-8">
                <?php  
                    $ordersResult = $db->query('SELECT * FROM order_details where user_id = ? ORDER BY created_at desc', $profileResult['id'] )->fetchAll();
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
                                        foreach ($ordersResult as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['created_at']; ?></td>
                                                <td><?php echo $row['order_no']; ?></td>
                                                <td>£<?php echo $row['total']; ?></td>
                                                <td> 
                                                    <?php
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
                        <?php 
                    } else { ?>
                        <p class='lead'><em>You have no orders.</em></p>
                        <?php 
                    }
                ?>
            </div>
            <div class="col-md-4 ml-auto">
                <?php include_once $root . "/views/customermenu.php";?>
            </div>
        </div>
    </div>
</div>

<?php include_once $root . "/views/footer.php"; ?>