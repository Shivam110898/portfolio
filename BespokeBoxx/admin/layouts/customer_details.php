<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);


if(isset($_COOKIE['REMEMBER_ME'])) {
    $userid=decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser=$db->query('select * from admin_user where email = ?', $userid)->fetchAll();

    $count=count($getuser);

    if($count > 0) {
        $_SESSION['USER']=$userid;
    }
} else if(!isset($_COOKIE['REMEMBER_ME']) && !isset($_SESSION['USER'])) {
    header("location: /layouts/logout.php");
}

if (isset($_GET["id"])) {
    $userResult = $db->query('SELECT * FROM user where id = ?', $_GET["id"])->fetchArray();
    $orderHistory = $db->query('SELECT * FROM order_details where user_id = ?', $_GET["id"])->fetchAll();
    $addresses = $db->query('SELECT * FROM user_address where user_id = ? and is_deleted = ?', $userResult["id"], "0")->fetchAll();
}

include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>

<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="col-sm-6">
                <div class="page-header">
                    <h1>Customer No : <?php echo $userResult["id"];?></h1>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header">
                    <h1>Last Login : <?php echo date("d/m/Y H:i:s", strtotime($userResult['last_login']));?></h1>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12 ">
                <div class='table-responsive'>
                    <table class='table table-borderless '>
                        <thead>
                            <tr>

                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php 
                                        echo $userResult["first_name"]." ".$userResult["last_name"]."<br>";
                                        echo $userResult["email"]."<br>";
                                        echo $userResult["phone_number"]."<br>";
                                    ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="page-header">
                <h1>Order History</h1>
            </div>
            <div class="col-lg-12 ">
                <div class='table-responsive'>
                    <table class='table table-borderless '>
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderHistory as $order){ ?>
                            <tr>
                                <td><?php echo $order["id"]; ?></td>
                                <td><?php echo date("d/m/Y H:i:s", strtotime($order['created_at'])); ?></td>
                                <td><button onclick="ViewOrderDetails('<?php echo $order['id'];  ?>')" type="button"
                                        class='btn bg-dark text-white btn-md'>
                                        <span class='fa fa-eye'></span>
                                    </button>
                                   
                                    <?php
                            if ($order['status'] == 0) {
                            ?>
                                    <button
                                        onclick="ToggleStatus('dispatched','<?php echo $order['id'];  ?>','/logics/logic.orders.php');"
                                        class="btn btn-warning ">Pending</button>
                                    <?php } else { ?>
                                    <button
                                        onclick="ToggleStatus('pending','<?php echo $order['id'];  ?>','/logics/logic.orders.php');"
                                        class="btn btn-success ">Dispatched</button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="page-header">
                <h1>Addresses</h1>
            </div>
            <div class="col-lg-12 ">
                <div class='table-responsive'>
                    <table class='table table-borderless '>
                        <thead>
                            <tr>
                                <th>Address Line 1</th>
                                <th>Address Line 2</th>
                                <th>City/Town</th>
                                <th>Country</th>
                                <th>POSTCODE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($addresses as $address){ ?>
                            <tr>
                            <td><?php echo $address["address_line_1"]; ?></td>
                            <td><?php echo $address["address_line_2"]; ?></td>
                            <td><?php echo $address["city"]; ?></td>
                            <td><?php echo $address["country"]; ?></td>
                            <td><?php echo $address["post_code"]; ?></td>
                                
                            </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>