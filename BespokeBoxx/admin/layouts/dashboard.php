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

include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";

$productsResult = $db->query('SELECT * FROM products where is_deleted = ? ', '0')->fetchAll();
$customersResult = $db->query('SELECT * FROM user where is_deleted = ? and user_type_id=5  ', '0')->fetchAll();
$usersResult = $db->query('SELECT * FROM admin_user where is_deleted = ?', '0')->fetchAll();
$rolesResult = $db->query('SELECT * FROM user_type where is_deleted = ?', '0')->fetchAll();
$ordersResult = $db->query('SELECT * FROM order_details')->fetchAll();
$pending = $db->query('SELECT * FROM order_details where status = ? ', '0')->fetchAll();
$itemssold = $db->query('SELECT * FROM order_details where status != ?','2')->fetchAll();
$prices = $db->query('SELECT total FROM order_details where status = ?', '1')->fetchAll();
$completedsResult = $db->query('SELECT * FROM order_details where status = ?','1')->fetchAll();
$sitecount = $db->query('SELECT * FROM visitor_activity_logs')->fetchAll();

?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>Dashboard</h1>
                </div>
            <?php
                $userRole = $db->query('SELECT * FROM admin_user WHERE email = ?', $_SESSION['USER'],)->fetchArray();
                if ($userRole['user_type_id'] == 1 ) {
                    ?>
                    <div class="column">
                        <div class="card">
                            <h3>Total Revenue</h3>
                            <h3><i class="fas fa-pound-sign"></i></h3>
                            <h3>
                                <?php 
                                    foreach($itemssold as $sale ) {
                                        $revenue+= $sale["total"];
                                    }
                                    if ($revenue > 0 ){
                                        echo number_format($revenue,2);
                                    } else {
                                        echo "00.00";
                                    }
                                ?>
                            </h3>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <h3>Est Proj Revenue</h3>
                            <h3><i class="fas fa-pound-sign"></i></h3>
                            <h3>
                                <?php 
                                    $pr;
                                    $allProducts = $db->query('SELECT product_id FROM products_to_category where category_id IN (3,4,5,6,9)')->fetchAll();
                                    foreach($allProducts as $product) {
                                        $getItem = $db->query('SELECT id,name,SKU,cost,price,quantity,image FROM products WHERE id = ?',$product["product_id"])->fetchArray();
                                        if ($getItem['id'] == $product["product_id"]){
                                            $pr+= $getItem["price"] * $getItem["quantity"];
                                        }
                                    }
                                    if ($pr > 0 ){
                                        echo $pr;
                                    } else {
                                        echo "00.00";
                                    }
                                ?>
                            </h3>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <h3>Gross Profit</h3>
                            <h3><i class="fas fa-pound-sign"></i></h3>
                            <h3>
                                <?php 
                                    $gp;
                                    foreach($itemssold as $order) {
                                        $orderItems = $db->query('SELECT * FROM order_items where order_id  = ?', $order['id'])->fetchAll();
                                        foreach($orderItems as $item) { 
                                            $product = $db->query('SELECT id,name,SKU,cost,price,quantity,image FROM products WHERE id = ?',$item["product_id"])->fetchArray();
                                            $gp += $product['price'] - $product['cost'];
                                        }
                                    }
                                    if ($gp > 0 ){
                                        echo $gp;
                                    } else {
                                        echo "00.00";
                                    }
                                ?>
                            </h3>
                        </div>
                    </div>
                    
                   
                    <div class="column">
                        <div class="card">
                            <h3>Customers</h3>
                            <h3><i class="fas fa-user-friends"></i></h3>
                            <h3><?php echo count($customersResult); ?></h3>
                            <a href="/layouts/customers.php" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <h3>Products</h3>
                            <h3><i class="fas fa-gift"></i></h3>
                            <h3><?php echo count($productsResult); ?></h3>
                            <a href="/layouts/products.php" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <h3>Visitor Log</h3>
                            <h3><i class="fas fa-user"></i></h3>
                            <h3><?php echo count($sitecount); ?></h3>
                            <a href="/layouts/vistor_logs.php" class="stretched-link"></a>
                        </div>
                    </div>
                    <?php
                }
                if ($userRole['user_type_id'] ==  3 ) { ?>
                    <div class="column">
                        <div class="card">
                            <h3>Products</h3>
                            <h3><i class="fas fa-gift"></i></h3>
                            <h3><?php echo count($productsResult); ?></h3>
                            <a href="/layouts/products.php" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <h3>Categories</h3>
                            <h3><i class="fas fa-gift"></i></h3>
                            <h3><?php echo count($categoriesResult); ?></h3>
                            <a href="/layouts/categories.php" class="stretched-link"></a>

                        </div>
                    </div>
                    <div class="column">
                        <div class="card">
                            <h3>Customers</h3>
                            <h3><i class="fas fa-user-friends"></i></h3>
                            <h3><?php echo count($customersResult); ?></h3>
                            <a href="/layouts/customers.php" class="stretched-link"></a>

                        </div>
                    </div>
                    <?php
                }
                if ($userRole['user_type_id'] ==  4 ) { ?>
                    <div class="column">
                        <div class="card">
                            <h3>Pending</h3>
                            <h3><i class="fas fa-shopping-basket"></i></h3>
                            <h3><?php echo count($pending); ?></h3>
                            <!-- <a href="products.php" class="stretched-link"></a> -->

                        </div>
                    </div>
                    <?php
                }
            ?>
            </div>
            <div class="col-sm-12">
                <div class="page-header">
                    <h1><i class="fas fa-tasks"></i> Pending Orders : <?php echo count($pending)?></h1>
                </div>
                <div id="result">
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        LoadPendingDetails();
                        $('#search_text').keyup(function () {
                            var search = $(this).val();
                            if (search != '') {
                                LoadPendingDetails(search);
                            } else {
                                LoadPendingDetails();
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>