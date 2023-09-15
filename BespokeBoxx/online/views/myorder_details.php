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

if (isset($_GET["order_no"])) {
    $ordersResult = $db->query('SELECT * FROM order_details where order_no = ?', $_GET["order_no"])->fetchArray();
    $hamper_ids = $db->query('SELECT DISTINCT hamper_id FROM order_items where order_id = ?', $ordersResult["id"])->fetchAll();
}
include_once $root . "/views/header.php";
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Order # <?php echo $ordersResult["order_no"] ;?></div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                    <?php 
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
                        <main class="totals">
                            <div class="subtotal">
                                <span class="label">Subtotal: </span>
                                <?php if($ordersResult["discount_applied"] == null ){ ?>
                                <span class="amount">
                                    £<?php echo $subtotal;?>
                                </span>

                                <?php } else if($ordersResult["discount_applied"] != null){ ?>
                                <span class="amount linethrough">
                                    £<?php echo $subtotal;?>
                                </span>
                                <?php } ?>
                            </div>
                                <?php if($ordersResult["discount_applied"] != null ){ ?>

                                <div class="subtotal">
                                    <span class="property">
                                        <?php 
                                            $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $ordersResult["discount_applied"])->fetchArray();
                                            if ($discount['discount_type'] == '%TAGE') {
                                                echo $discount["description"]." ".$discount["discount_value"].'% discount';
                                            } else if ($discount['discount_type'] == 'AMOUNT') {
                                                echo $discount["description"]." ".'£'.$discount["discount_value"].' discount';
                                            }
                                            ?>
                                    </span>
                                    <span class="amount">
                                        <?php 
                                            $discountVal = 0.00;
                                            if ($discount['discount_type'] == '%TAGE') {
                                                $discount_value = ($discount["discount_value"] / 100) * $subtotal;
                                                $discountVal = $subtotal - $discount_value;
                                    
                                            } else if ($discount['discount_type'] == 'AMOUNT') {
                                                $discount_value = $discount["discount_value"];
                                                $discountVal = $subtotal - $discount_value;
                                            }
                                            echo number_format((float)$discountVal, 2, '.', '');
                                            
                                            ?>
                                    </span>

                                </div>
                                <?php  }
                                if(count($message) > 0) { ?>

                                    <div class="subtotal">
                                        <span class="label">Gift Message:</span>
                                        <span class="amount">£<?php echo number_format((float)$messageCharges, 2, '.', '')?></span>
                                    </div>
                                <?php  }?>
                            <div class="subtotal">
                                <span class="label">Delivery:</span>
                                <span class="amount">£<?php echo number_format((float)$deliveryCharges, 2, '.', '')?></span>
                            </div>
                            <div class="subtotal">
                                <span class="label">Total:</span>
                                <span class="amount ">£<?php echo $ordersResult["total"] ;?></span>
                            </div>
                        </main>
                    </div>
                </div>
                <div class="row">
                    <?php 
                        $counter = 0;
                        foreach ($hamper_ids as $hamper) {
                            $orderItems = $db->query('SELECT * FROM order_items where hamper_id = ?', $hamper["hamper_id"])->fetchAll();
                            $getDeliveryAddress = $db->query('SELECT * FROM delivery_addresses where hamper_id = ?', $hamper["hamper_id"])->fetchArray();
                            $address = $db->query('SELECT * FROM user_address where id = ?', $getDeliveryAddress['address_id'])->fetchArray();
                            $message = $db->query('SELECT * FROM gift_messages where hamper_id = ?', $hamper['hamper_id'])->fetchArray();
                            $counter++; ?>
                            <div class="shopping-card" data-aos="fade-left">
                                <div class="col-sm-12">
                                    <h2 class="boxcount"><span class="count"><?php echo "#".$counter; ?></span></h2>
                                    <div class="row">
                                        <div class="col">
                                            <?php
                                                foreach ($orderItems as $item) {
                                                    if($item['hamper_id'] == $hamper['hamper_id']){

                                                        if($item['type'] == "colour") {
                                                            $getBoxxColour = $db->query('SELECT id, name, image FROM products where id=?', $item['product_id'])->fetchArray();
                                                            $image_src = "/uploadedimgs/" . $getBoxxColour["image"];
                                                            echo "<img class='basketImg' src='".$image_src."'>"; 
                                                        } 
                                                        if($item['type'] == "filling") {

                                                            $getBoxxFillinng = $db->query('SELECT id, name, image FROM products where id=?', $item['product_id'])->fetchArray(); 
                                                            $image_src = "/uploadedimgs/" . $getBoxxFillinng["image"];
                                                            echo "<img class='basketImg' src='".$image_src."'>";   
                                                        }                                              
                                                        if($item['type'] == "size") {
                                                            $getBoxxSize = $db->query('SELECT id, name,image ,price FROM products where id=?', $item['product_id'])->fetchArray();
                                                            $getprops = $db->query('SELECT * FROM product_properties where product_id = ? AND property_name = ?', $k, 'Size')->fetchArray();

                                                            echo "<p class='property'>".$getBoxxSize["name"]. ", £".$getBoxxSize["price"]."<br> ".$getprops['property_value']."</p>" ; 

                                                        } 
                                                        
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <?php 
                                                foreach ($orderItems as $item) {
                                                    if($item['hamper_id'] == $hamper['hamper_id']){

                                                        if($item['type'] == "product") {
                                                            $getItems = $db->query('SELECT name, price,image FROM products where id=?', $item['product_id'])->fetchArray();
                                                            $image_src = "/uploadedimgs/" . $getItems["image"]; ?>
                                                            <div class='table-responsive'>
                                                                <table class='table table-borderless'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><?php  echo "<img class='basketImg' src='".$image_src."'>"; ?></td>
                                                                            <td><p class="property"><?php echo $getItems["name"]; ?></p>
                                                                            </td>
                                                                            <td><p class="property">X <?php echo $item['quantity']; ?></p></td>
                                                                            <td><p class="property">£ <?php echo $getItems["price"]*$item['quantity']; ?></p>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <?php   
                                                        }
                                                        if($item['type'] == "hotm") {
                                                            $getItems = $db->query('SELECT name, price,image FROM products where id=?', $item['product_id'])->fetchArray();
                                                            $image_src = "/uploadedimgs/" . $getItems["image"]; 
                                                            $hotm_products = $db->query('SELECT * FROM product_properties where product_id = ? ', $$item['product_id'])->fetchAll(); ?>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <p class="property"><?php echo $getItems['name']; ?></p>
                                                                    <img class='hotmImg' src="<?php echo $image_src ;?>"> 
                                                                    <?php
                                                                        foreach($hotm_products as $hotm_product){
                                                                            ?>
                                                                            <p class="property"><?php echo $hotm_product["property_value"]; ?></p>    
                                                                            <?php 
                                                                        } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="price">Boxx Total : £<?php echo $getDeliveryAddress['hamper_total']; ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <?php if(count($message) > 0) { ?>
                                            <p class="recipient_tag">Gift Message: </p>
                                            <div class="product-container addressCard">
                                                <input name="AddressRadio" type="radio" hidden>
                                                <label class="clickable"><span class="checked-box">&#10004;</span></label>
                                                <p class="address"><?php echo $message['message']; ?></p>
                                            </div>
                                        <?php } ?>
                                            <p class="recipient_tag">Recipient Delivery Details:</p>
                                            <div class="product-container addressCard">
                                                <input id="<?php echo $row['id'].$key; ?>" name="AddressRadio" type="radio" hidden>
                                                <label class="clickable"><span class="checked-box">&#10004;</span></label>
                                                <p class="address"><?php echo $address['first_name']."<br>".$address['last_name']."<br>".$address['phone_number']."<br>".$address['address_line_1']."<br>".$address['city']."<br>".$address['country']."<br>".$address['post_code']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="property">Delivery within 5-7 working days (<?php echo $getDeliveryAddress['hamper_total'] < 35.00 ? "£4.99" : "FREE"; ?>)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                        } 
                    ?>
                </div>
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