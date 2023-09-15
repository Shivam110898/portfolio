<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);


// Check if the user is logged in, if not then redirect to login page
if(isset($_COOKIE['REMEMBER_ME'] )){
    // Decrypt cookie variable value
    $userid = decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser = $db->query('select * from admin_user where email = ?', $userid)->fetchAll();
    $count = count($getuser);
    if( $count > 0 ){
       $_SESSION['USER'] = $userid; 
    }
} else if(!isset($_SESSION['USER'] )){
    header("location: /layouts/logout.php");
}

if (isset($_GET["id"])) {
    $ordersResult = $db->query('SELECT * FROM order_details where id = ?', $_GET["id"])->fetchArray();
    $orderItems = $db->query('SELECT * FROM order_items where order_id = ?', $ordersResult["id"])->fetchAll();
    $hamper_ids = $db->query('SELECT DISTINCT hamper_id FROM order_items where order_id = ?', $ordersResult["id"])->fetchAll();
}

include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";

$deliveryCharges;
$messageCharges;
$subtotal;
foreach ($hamper_ids as $hamper) {
    $getDeliveryAddress = $db->query('SELECT * FROM delivery_addresses where hamper_id = ?', $hamper["hamper_id"])->fetchArray();
    $message = $db->query('SELECT * FROM gift_messages where hamper_id = ?', $hamper['hamper_id'])->fetchArray();
    $getDeliveryAddress['hamper_total'] < 35.00 ? $deliveryCharges += 4.99 : $deliveryCharges;
    count($message) > 0 ? $messageCharges += 1.49 : $messageCharges+=0.00;
    $subtotal += $getDeliveryAddress['hamper_total'];
}
?>

<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="col-sm-6">
                <div class="page-header">
                    <h3>Order # : <?php echo $ordersResult["order_no"];?></h3>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header">
                    <h3>Order Date : <?php echo date("d/m/Y H:i:s", strtotime($ordersResult['created_at']));?></h3>
                </div>
            </div>
            <div class="col-sm-12">
                <div class='table-responsive'>
                    <table class='table table-borderless '>
                        <thead>
                            <tr>
                            <th>Payment ID</th>
                            <th>Ordered by</th>
                            <th>Subtotal</th>
                                <th>Delivery Charges</th>
                                <th>Message Charges</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php 
                                    if ($ordersResult['status'] == 0) { ?>
                                        <button onclick="if (confirm('Are you sure this order has been dispatched?')) ToggleStatus('dispatched','<?php echo $ordersResult['id'];  ?>','/logics/logic.orders.php');" class="btn btn-warning ">Pending</button>
                                        <button onclick="if (confirm('Are you sure you want to cancel this order?')) ToggleStatus('cancel','<?php echo $ordersResult['id'];  ?>','/logics/logic.orders.php');" class="btn btn-danger " >Cancel</button>

                                        <?php 
                                    } else if ($ordersResult['status'] == 1){ 
                                        ?>
                                        <button onclick="ToggleStatus('pending','<?php echo $ordersResult['id'];  ?>','/logics/logic.orders.php');" class="btn btn-success " disabled>Dispatched</button>
                                        <button onclick="if (confirm('Are you sure you want to cancel this order?')) ToggleStatus('cancel','<?php echo $ordersResult['id'];  ?>','/logics/logic.orders.php');" class="btn btn-danger " >Cancel</button>

                                        <?php 
                                    } else if ($ordersResult['status'] == 2){ 
                                        ?>
                                            <button disabled class="btn btn-danger " >Cancelled</button>

                                        <?php 
                                    } 
                                ?>

                                        <td><?php echo $ordersResult['payment_id'];?></td>
                                <td>
                                    <?php 
                                        $customer = $db->query('SELECT * FROM user where id = ?', $ordersResult['user_id'])->fetchArray();
                                        $usertype = $db->query('SELECT * FROM user_type where id = ?', $customer['user_type_id'])->fetchArray();
                                        echo $usertype["role"]."<br>";
                                        echo $customer["first_name"]." ".$customer["last_name"]."<br>";
                                        echo $customer["email"]."<br>";
                                        echo $customer["phone_number"]."<br>";
                                    ?>
                                </td>
                                <td><?php if($ordersResult["discount_applied"] != null ){ 
                                     echo "£".$subtotal."<br>"; 
                                                $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $ordersResult["discount_applied"])->fetchArray();
                                                if ($discount['discount_type'] == '%TAGE') {
                                                    echo $discount["description"]." ".$discount["discount_value"].'% discount ';
                                                } else if ($discount['discount_type'] == 'AMOUNT') {
                                                    echo $discount["description"]." ".'£'.$discount["discount_value"].' discount ';
                                                }
                                                $discountVal = 0.00;
                                                if ($discount['discount_type'] == '%TAGE') {
                                                    $discount_value = ($discount["discount_value"] / 100) * $subtotal;
                                                    $discountVal = $subtotal - $discount_value;
                                        
                                                } else if ($discount['discount_type'] == 'AMOUNT') {
                                                    $discount_value = $discount["discount_value"];
                                                    $discountVal = $subtotal - $discount_value;
                                                }
                                                echo "<b>£".number_format((float)$discountVal, 2, '.', '')."</b>";
                                                
                                    }  else {
                                    echo "£".$subtotal; 
                                    }?></td>
                                <td><b>£<?php echo number_format((float)$deliveryCharges, 2, '.', '')?></b></td>
                                <td><b>£<?php echo number_format((float)$messageCharges, 2, '.', '')?></b></td>
                                <td><b>
                                    <?php
                                    echo "£".$ordersResult['total']; 
                                    ?></b>
                            
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12">
                <?php
                    $count  = 0; 
                    
                    foreach($hamper_ids as $hamper){ 
                        $count++;
                        echo "<p>Boxx ".$count."</p>";
                        $getDeliveryAddress = $db->query('SELECT * FROM delivery_addresses where hamper_id = ?', $hamper["hamper_id"])->fetchArray();
                        $address = $db->query('SELECT * FROM user_address where id = ?', $getDeliveryAddress['address_id'])->fetchArray();
                        $message = $db->query('SELECT * FROM gift_messages where hamper_id = ?', $hamper['hamper_id'])->fetchArray();

                        ?>
                        <div class='table-responsive'>
                            <table class='table table-borderless '>
                                <thead>
                                    <tr>
                                        <th>Recipient</th>
                                        <th>Items</th>
                                        <th>Message</th>
                                        <th>Boxx Total</th>
                                        <th>Delivery Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $address['first_name']."<br>".$address['last_name']."<br>".$address['phone_number']."<br>".$address['address_line_1']."<br>".$address['city']."<br>".$address['country']."<br>".$address['post_code']; ?></td>
                                        <td>
                                            <?php 
                                                foreach($orderItems as $item){
                                                    if($item['hamper_id'] == $hamper['hamper_id']){
                                                        $row = $db->query('SELECT * FROM products where id = ?', $item["product_id"])->fetchArray();
                                                        if($item['type'] == "colour") {
                                                            $image_src = "/uploadedimgs/" . $row["image"];
                                                            echo "<img class='basketImg' src='".$image_src."'> "; 
                                                            echo $row["name"]."<br>";

                                                        }
                                                        if($item['type'] == "size") {
                                                            echo "<br>";

                                                            echo "<img class='basketImg' src='".$image_src."'> "; 
                                                            echo $row["name"]."<br>";
                                                        }
                                                        if($item['type'] == "filling") {
                                                            echo "<br>";

                                                            $image_src = "/uploadedimgs/" . $row["image"];
                                                            echo "<img class='basketImg' src='".$image_src."'>"."<br>";; 

                                                        }
                                                        if($item['type'] == "product") {
                                                            echo "<br>";

                                                            $image_src = "/uploadedimgs/" . $row["image"];
                                                            echo "<img class='basketImg' src='".$image_src."'> "; 
                                                            echo $row["name"]." x ".$item["quantity"]."<br>";
                                                        }
                                                        if($item['type'] == "hotm") {
                                                            echo "<br>";

                                                            $image_src = "/uploadedimgs/" . $row["image"];
                                                            echo "<img class='basketImg' src='".$image_src."'> "; 
                                                            echo $row["name"]." x ".$item["quantity"]."<br>";
                                                        }
                                                    }
                                                    
                                                } 
                                            ?>
                                        </td>
                                        <td><?php  echo $message['message']; ?></td>
                                        <td>£<?php  echo $getDeliveryAddress['hamper_total']; ?></td>
                                        <td><?php  echo $getDeliveryAddress['hamper_total'] < 35.00 ? "£4.99" : "FREE"; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php 
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>