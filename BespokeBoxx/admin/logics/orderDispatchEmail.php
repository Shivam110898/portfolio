<?php

$orderDetails = $db->query('SELECT * FROM order_details where id = ?', $id)->fetchArray();
$orderItems = $db->query('SELECT * FROM order_items where order_id = ?', $orderDetails["id"])->fetchAll();
$hamper_ids = $db->query('SELECT DISTINCT hamper_id FROM order_items where order_id = ?', $orderDetails["id"])->fetchAll();
$orderedBy = $db->query('SELECT * FROM user where id = ?', $orderDetails['user_id'])->fetchArray();

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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>BespokeBoxx &mdash; You Design, We Deliver.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
    <meta http–equiv="“Content-Type”" content="“text/html;" charset="UTF-8”">
    <meta http–equiv="“X-UA-Compatible”" content="“IE=edge”">
</head>

<body>
    <div class="site-wrap" style="min-height: 70vh;font-family: 'Quicksand', sans-serif;overflow-x: hidden !important; background:white;">
        <div class="site-navbar bg-white " style="margin-bottom: 0px;z-index: 1999;position: relative;background: #fff !important;">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="https://bespokeboxx.co.uk/index.php" class="js-logo-clone" style="transition: .3s all ease;text-transform: uppercase;letter-spacing: .2em;font-size: 20px;padding-left: 10px;padding-right: 10px;color: #000 !important;"><img src="https://bespokeboxx.co.uk/images/Logo.png" style="width: 100px;"></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="site-section" data-aos="fade-top" style="padding: 2.5em 0;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title" style="color: #ee4266;">ORDER # <?php echo $orderDetails['order_no']; ?> : DISPATCHED</h1>
                        <h2 class="sub-title">Hello <?php echo $orderedBy["email"]; ?>, we're pleased to inform you that your order has now been dispatched and passed onto the courier.</h2>
                        <img src="https://bespokeboxx.co.uk/images/tick.png" class="tick-img" style="width: 150px;display: block;margin-left: auto;margin-right: auto;">
                    </div>
                    <div class="col-md-12">
                        <div id="summarySection" class="panels">
                            <button class="accordion" style="border: 0;background-color: #fff;color: teal;cursor: default;padding: 18px;width: 100%;margin: 5px;text-align: center;font-size: 20px;transition: 0.4s;">Order Summary</button>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php 
                                       $counter = 0;
                                       foreach ($hamper_ids as $hamper) {
                                           $orderItems = $db->query('SELECT * FROM order_items where hamper_id = ?', $hamper["hamper_id"])->fetchAll();
                                           $getDeliveryAddress = $db->query('SELECT * FROM delivery_addresses where hamper_id = ?', $hamper["hamper_id"])->fetchArray();
                                           $address = $db->query('SELECT * FROM user_address where id = ?', $getDeliveryAddress['address_id'])->fetchArray();
                                           $message = $db->query('SELECT * FROM gift_messages where hamper_id = ?', $hamper['hamper_id'])->fetchArray();
                                           $counter++; ?>
                                            <div class="col" style="box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);margin: 30px auto;text-align: center;background-color: #fff;color: teal;border-radius: 25px;padding-top: 10px;padding-bottom: 10px;height: fit-content;max-width: 350px;width:90%; border: 2px solid #008080 ;">
                                                <div class="col" style="margin: 10px auto;">
                                                    <h2 class="boxcount" style="color: #ee4266;font-size: 16px;font-weight: 600;letter-spacing: 2px;text-transform: uppercase;line-height: 1;margin: 5px 0 25px 0;display: flex;justify-content: center;margin-top: 20px;"><span class="count" style="color: #fff;background: #ee4266;padding: 8px;margin-left: 6px;position: relative;top: -1px;width: 18px;height: 18px;border-radius: 50px;font-size: 12px;letter-spacing: 0;display: flex;align-items: center;justify-content: center;"><?php echo "#".$counter; ?></span></h2>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col" style="margin: 10px auto;">
                                                            <?php
                                                                foreach($orderItems as $item){
                                                                    if($item['hamper_id'] == $hamper['hamper_id']){
                                                                        $row = $db->query('SELECT * FROM products where id = ?', $item["product_id"])->fetchArray();
                                                                        if($item['type'] == "colour") {
                                                                            echo "<p class='property'>".$row["name"];
                                                                        }
                                                                        if($item['type'] == "size") {
                                                                            echo "<p class='property'>".$row["name"];
                                                                        }
                                                                        if($item['type'] == "filling") {
                                                                            echo "<p class='property'>".$row["name"];
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col" style="margin: 10px auto;">
                                                            <?php 
                                                                foreach ($orderItems as $item) {
                                                                    if($item['hamper_id'] == $hamper['hamper_id']){
                                                                        if($item['type'] == "product") {
                                                                            $getItems = $db->query('SELECT name, price,image FROM products where id=?', $item['product_id'])->fetchArray();
                                                                            $image_src = "/uploadedimgs/" . $getItems["image"]; ?>
                                                                            <div class="table-responsive" style="margin: 10px auto;">
                                                                                <table class="table table-borderless" style="margin: 10px auto;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            
                                                                                            <td>
                                                                                                <p class="property" style="color: #ee4266;font-size: 13px;">
                                                                                                    <?php echo $getItems["name"]; ?></p>
                                                                                            </td>
                                                                                            <td>
                                                                                                <p class="property" style="color: #ee4266;font-size: 13px;">X<?php echo $item['quantity']; ?></p>
                                                                                            </td>
                                                                                            <td>
                                                                                                <p class="property" style="color: #ee4266;font-size: 13px;">
                                                                                                    £<?php echo $getItems["price"]*$item['quantity']; ?>
                                                                                                </p>
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
                                                                            $hotm_products = $db->query('SELECT * FROM product_properties where product_id = ? ', $item['product_id'])->fetchAll(); ?>
                                                                            <div class="row" style="margin: 10px auto;">
                                                                                <div class="col" style="margin: 10px auto;">
                                                                                    <p class="property" style="color: #008080;font-size: 13px;"><?php echo $getItems['name']; ?></p>
                                                                                    <?php
                                                                                        foreach($hotm_products as $hotm_product){
                                                                                            ?>
                                                                                            <p class="property" style="color: #ee4266;font-size: 13px;">
                                                                                            <?php echo $hotm_product["property_value"]; ?></p>
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
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col-sm-12" style="margin: 10px auto;">
                                                            <p class="price" style="color: teal;font-size: 22px;">Boxx Total (exl delivery) : £<?php echo $getDeliveryAddress['hamper_total'];  ?></p>
                                                            <?php 
                                                                if(count($message) > 0) { ?>
                                                                    <p class="recipient_tag" style="text-align: left;color: #ee4266;margin: 10px;font-size: 14px;">Gift Message: </p>
                                                                    <div class="product-container addressCard" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);width: 270px;margin: 10px ;padding: 10px 10px;text-align: left;background-color: #e9ecef;cursor: pointer;position: relative;border-radius: 10px;">
                                                                        <label class="clickable" style="position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;border-radius: 10px;transition: all ease .5s;z-index: 1;border-color: #ee4266;box-shadow: 0px 0px 6px 2px #ee4266;"><span class="checked-box" style="position: absolute;top: 0px;right: 0px;width: 22px;height: 22px;border-radius: 5px;background-color: #ee4266;color: #fff;text-align: center;display: block;">&#10004;</span></label>
                                                                        <p class="address" style="color: #000;font-size: 14px;word-wrap: break-word;"><?php echo $message['message']; ?></p>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <p class="recipient_tag" style="text-align: left;color: #ee4266;margin: 10px;font-size: 14px;">Recipient Delivery Details:</p>
                                                                <div class="product-container addressCard" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);width: 270px;margin: 10px auto;padding: 10px 10px;text-align: left;background-color: #e9ecef;cursor: pointer;position: relative;border-radius: 10px;">
                                                                    <label class="clickable" style="position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;border-radius: 10px;transition: all ease .5s;z-index: 1;border-color: #ee4266;box-shadow: 0px 0px 6px 2px #ee4266;"><span class="checked-box" style="position: absolute;top: 0px;right: 0px;width: 22px;height: 22px;border-radius: 5px;background-color: #ee4266;color: #fff;text-align: center;display: block;">&#10004;</span></label>
                                                                    <p class="address" style="color: #000;font-size: 14px;word-wrap: break-word;">
                                                                        <?php echo $address['first_name'].' '.$address['last_name'].', '.$address['phone_number'].', '.$address['address_line_1'].", ".$address['city'].", ".$address['country'].", ".$address['post_code']; ?>
                                                                    </p>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col-sm-12" style="margin: 10px auto;">
                                                            <p class="property" style="color: #ee4266;font-size: 13px;">Delivery within 5-7 working days (<?php echo $getDeliveryAddress['hamper_total'] < 35.00 ? "£4.99" : "FREE"; ?>)</p>
                                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                        } 
                                    ?>
                                </div>
                                <div class="col-sm-12">
                                    <main class="totals" style="left: 0;right: 0;background: #e9ecef;border-bottom: 1px solid #dee2e6;">
                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Subtotal: </span>

                                            <?php  if($ordersResult["discount_applied"] == null ){ ?>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">

                                                £<?php echo $subtotal;?>
                                            </span>

                                            <?php } elseif($ordersResult["discount_applied"] == null ){ ?>
                                            <span class="amount linethrough" style="-webkit-text-decoration-line: line-through;text-decoration-line: line-through;text-decoration-color: #ee4266;text-decoration-thickness: 2px;color: #494f54;margin-left: 10px;font-weight: 600;">

                                            £<?php echo $subtotal;?>
                                            </span>
                                            <?php } ?>

                                        </div>
                                        <?php if($ordersResult["discount_applied"] != null ){ ?>

                                        <div class="subtotal">
                                            <span class="property" style="color: #ee4266;font-size: 13px;">
                                                <?php 
                                                    $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $ordersResult["discount_applied"])->fetchArray();
                                                    if ($discount['discount_type'] == '%TAGE') {
                                                        echo $discount["description"]." ".$discount["discount_value"].'% discount';
                                                    } else if ($discount['discount_type'] == 'AMOUNT') {
                                                        echo $discount["description"]." ".'£'.$discount["discount_value"].' discount';
                                                    }
                                                    ?>
                                            </span>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">
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
                                        <?php  }?>

                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Gift Message:</span>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo number_format((float)$messageCharges, 2, '.', '')?></span>
                                        </div>

                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Delivery:</span>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo number_format((float)$deliveryCharges, 2, '.', '')?></span>
                                        </div>
                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Total:</span>
                                            <span class="amount " style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo $orderDetails["total"] ;?></span>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
