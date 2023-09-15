<?php
$orderDetails = $db->query('SELECT * FROM order_details WHERE id = ?', $_SESSION['lastOrderId'])->fetchArray();
$profileResult;
if (isset($_SESSION["CUSTOMER_LOGIN"])) {
    $profileResult = $db->query('SELECT * FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();
    
} else if(isset($_SESSION["GUEST_LOGIN"])){
    $profileResult = $db->query('SELECT * FROM user where id = ?', $_SESSION['GUEST_LOGIN'])->fetchArray();
    
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
                        <h1 class="title" style="color: #ee4266;">ORDER # <?php echo $orderDetails['order_no']; ?></h1>
                        <h2 class="sub-title">Thank you for your order <?php echo $profileResult["email"]; ?>. We hope
                            you have enjoyed your shopping experience with BespokeBoxx. You will recieve a dispatch email confirmation once your order has been passed onto the courier.</h2>
                        <img src="https://bespokeboxx.co.uk/images/tick.png" class="tick-img" style="width: 150px;display: block;margin-left: auto;margin-right: auto;">
                    </div>
                    <div class="col-md-12">
                        <div id="summarySection" class="panels">
                            <button class="accordion" style="border: 0;background-color: #fff;color: teal;cursor: default;padding: 18px;width: 100%;margin: 5px;text-align: center;font-size: 20px;transition: 0.4s;">Order Summary</button>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php 
                                        $counter = 0;
                                        foreach ($_SESSION['Cart'] as $key => $value) {
                                            $counter++; ?>
                                            <div class="col" style="box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);margin: 30px auto;text-align: center;background-color: #fff;color: teal;border-radius: 25px;padding-top: 10px;padding-bottom: 10px;height: fit-content;max-width: 350px;width:90%; border: 2px solid #008080 ;">
                                                <div class="col" style="margin: 10px auto;">
                                                    <h2 class="boxcount" style="color: #ee4266;font-size: 16px;font-weight: 600;letter-spacing: 2px;text-transform: uppercase;line-height: 1;margin: 5px 0 25px 0;display: flex;justify-content: center;margin-top: 20px;"><span class="count" style="color: #fff;background: #ee4266;padding: 8px;margin-left: 6px;position: relative;top: -1px;width: 18px;height: 18px;border-radius: 50px;font-size: 12px;letter-spacing: 0;display: flex;align-items: center;justify-content: center;"><?php echo "#".$counter; ?></span></h2>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col" style="margin: 10px auto;">
                                                            <?php
                                                                foreach ($value as $sub_key => $sub_val) {
                                                                    if (is_array($sub_val)) { 
                                                                        foreach ($sub_val as $k => $v) {
                                                                            if($sub_key == "colour") {
                                                                                $getBoxxColour = $db->query('SELECT id, name, image FROM products where id=?', $k)->fetchArray();
                                                                                echo "<p class='property'>".$getBoxxColour["name"];

                                                                            } 
                                                                        } 
                                                                        foreach ($sub_val as $k => $v) {
                                                                            if($sub_key == "filling") {

                                                                                $getBoxxFillinng = $db->query('SELECT id, name, image FROM products where id=?', $k)->fetchArray(); 
                                                                                echo "<p class='property'>".$getBoxxFillinng["name"];

                                                                            }                                              
                                                                        } 
                                                                        foreach ($sub_val as $k => $v) {
                                                                            if($sub_key == "size") {
                                                                                $getBoxxSize = $db->query('SELECT id, name,image ,price FROM products where id=?', $k)->fetchArray();
                                                                                $getprops = $db->query('SELECT * FROM product_properties where product_id = ? AND property_name = ?', $k, 'Size')->fetchArray();

                                                                                echo "<p class='property'>".$getBoxxSize["name"]. ", £".$getBoxxSize["price"]."<br> ".$getprops['property_value']."</p>" ; 

                                                                            } 
                                                                        }  
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col" style="margin: 10px auto;">
                                                            <?php 
                                                                foreach ($value as $sub_key => $sub_val) {
                                                                    if (is_array($sub_val)) { 
                                                                        foreach ($sub_val as $k => $v) {
                                                                            if($sub_key == "products") {
                                                                                $getItems = $db->query('SELECT name, price,image FROM products where id=?', $k)->fetchArray();
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
                                                                                                    <p class="property" style="color: #ee4266;font-size: 13px;">X<?php echo $v; ?></p>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <p class="property" style="color: #ee4266;font-size: 13px;">
                                                                                                        £<?php echo $getItems["price"]*$v; ?>
                                                                                                    </p>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <?php   
                                                                            }    
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col-sm-12" style="margin: 10px auto;">
                                                            <?php 
                                                                foreach ($value as $sub_key => $sub_val) {
                                                                    if($sub_key == "total") { ?>
                                                                        <p class="price" style="color: teal;font-size: 22px;">Boxx Total (exl delivery) : £<?php echo $sub_val;  ?></p>
                                                                        <?php 
                                                                    } 
                                                                } 
                                                                foreach ($value as $sub_key => $sub_val) {
                                                                    if($sub_key == 'gift_message'){  ?>
                                                                        <p class="recipient_tag" style="text-align: left;color: #ee4266;margin: 10px;font-size: 14px;">Gift Message: </p>
                                                                        <div class="product-container addressCard" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);width: 270px;margin: 10px ;padding: 10px 10px;text-align: left;background-color: #e9ecef;cursor: pointer;position: relative;border-radius: 10px;">
                                                                            <label class="clickable" style="position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;border-radius: 10px;transition: all ease .5s;z-index: 1;border-color: #ee4266;box-shadow: 0px 0px 6px 2px #ee4266;"><span class="checked-box" style="position: absolute;top: 0px;right: 0px;width: 22px;height: 22px;border-radius: 5px;background-color: #ee4266;color: #fff;text-align: center;display: block;">&#10004;</span></label>
                                                                            <p class="address" style="color: #000;font-size: 14px;word-wrap: break-word;"><?php echo $sub_val; ?></p>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                $addressResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted = ? ORDER BY created_at desc ', $profileResult['id'],'0' )->fetchAll();
                                                                if(count($addressResult) > 0) { ?>
                                                                    <p class="recipient_tag" style="text-align: left;color: #ee4266;margin: 10px;font-size: 14px;">Recipient Delivery Details:</p>
                                                                    <?php 
                                                                } 
                                                                foreach($addressResult as $row) { 
                                                                    foreach ($value as $sub_key => $sub_val) {
                                                                        if($sub_key == 'delivery_address_id'){
                                                                            if ($sub_val == $row['id']) {?>
                                                                            <div class="product-container addressCard" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);width: 270px;margin: 10px auto;padding: 10px 10px;text-align: left;background-color: #e9ecef;cursor: pointer;position: relative;border-radius: 10px;">
                                                                                <label class="clickable" style="position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;border-radius: 10px;transition: all ease .5s;z-index: 1;border-color: #ee4266;box-shadow: 0px 0px 6px 2px #ee4266;"><span class="checked-box" style="position: absolute;top: 0px;right: 0px;width: 22px;height: 22px;border-radius: 5px;background-color: #ee4266;color: #fff;text-align: center;display: block;">&#10004;</span></label>
                                                                                <p class="address" style="color: #000;font-size: 14px;word-wrap: break-word;">
                                                                                    <?php echo $row['first_name'].' '.$row['last_name'].', '.$row['phone_number'].', '.$row['address_line_1'].", ".$row['city'].", ".$row['country'].", ".$row['post_code']; ?>
                                                                                </p>
                                                                            </div>
                                                                            <?php 
                                                                            }
                                                                        }
                                                                    }
                                                                } 
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin: 10px auto;">
                                                        <div class="col-sm-12" style="margin: 10px auto;">
                                                            <?php 
                                                                foreach ($value as $sub_key => $sub_val) {
                                                                    if($sub_key == "total") { ?>
                                                                    <p class="property" style="color: #ee4266;font-size: 13px;">Delivery within 5-7 working days (<?php if($sub_val < 35.00){?>£4.99<?php } else {?>FREE<?php } ?>)</p>
                                                                    <?php 
                                                                    } 
                                                                } 
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                        } 
                                        foreach ($_SESSION['botmBoxx'] as $key => $value) {
                                            $counter++; ?>
                                            <div class="col" style="box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);margin: 30px auto;text-align: center;background-color: #fff;color: teal;border-radius: 25px;padding-top: 10px;padding-bottom: 10px;height: fit-content;max-width: 350px;width:90%; border: 2px solid #008080 ;">
                                                <div class="col" style="margin: 10px ;">
                                                    <h2 class="boxcount" style="color: #ee4266;font-size: 16px;font-weight: 600;letter-spacing: 2px;text-transform: uppercase;line-height: 1;margin: 5px 0 25px 0;display: flex;justify-content: center;margin-top: 20px;"><span class="count" style="color: #fff;background: #ee4266;padding: 8px;margin-left: 6px;position: relative;top: -1px;width: 18px;height: 18px;border-radius: 50px;font-size: 12px;letter-spacing: 0;display: flex;align-items: center;justify-content: center;"><?php echo "#".$counter; ?></span></h2>
                                                    <?php 
                                                        foreach ($value as $sub_key => $sub_val) {
                                                            if($sub_key == "productid") {
                                                                $hotm = $db->query('SELECT name, price,image FROM products where id=?', $sub_val)->fetchArray();
                                                                $image_src = "/uploadedimgs/" . $hotm["image"]; 
                                                                $hotm_products = $db->query('SELECT * FROM product_properties where product_id = ? ', $sub_val)->fetchAll(); ?>
                                                                <div class="row" style="margin: 10px auto;">
                                                                    <div class="col" style="margin: 10px auto;">
                                                                        <p class="property" style="color: #008080;font-size: 13px;"><?php echo $hotm['name']; ?></p>
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

                                                                <div class="row" style="margin: 10px auto;">
                                                                    <div class="col-sm-12" style="margin: 10px auto;">
                                                                        <?php 
                                                                            foreach ($value as $sub_key => $sub_val) {
                                                                                if($sub_key == "total") { ?>
                                                                                    <p class="price" style="color: teal;font-size: 22px;">Boxx Total (exl delivery) : £<?php echo $sub_val;  ?></p>
                                                                                    <?php 
                                                                                } 
                                                                            } 
                                                                        ?>
                                                                        <?php 
                                                                            foreach ($value as $sub_key => $sub_val) {
                                                                                if($sub_key == 'gift_message'){  ?>
                                                                                    <p class="recipient_tag" style="text-align: left;color: #ee4266;margin-top: 10px;font-size: 14px;">Gift Message: </p>

                                                                                    <div class="product-container addressCard" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);width: 270px;margin: 10px auto;padding: 10px 10px;text-align: left;background-color: #e9ecef;cursor: pointer;position: relative;border-radius: 10px;">
                                                                                        <label class="clickable" style="position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;border-radius: 10px;transition: all ease .5s;z-index: 1;border-color: #ee4266;box-shadow: 0px 0px 6px 2px #ee4266;"><span class="checked-box" style="position: absolute;top: 0px;right: 0px;width: 22px;height: 22px;border-radius: 5px;background-color: #ee4266;color: #fff;text-align: center;display: block;">&#10004;</span></label>
                                                                                        <p class="address" style="color: #000;font-size: 14px;word-wrap: break-word;"><?php echo $sub_val; ?></p>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                                
                                                                            $addressResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted = ? ORDER BY created_at desc ', $profileResult['id'],'0' )->fetchAll();
                                                                            if(count($addressResult) > 0) { ?>
                                                                                <p class="recipient_tag" style="text-align: left;color: #ee4266;margin-top: 10px;font-size: 14px;">Recipient Delivery Details:</p>
                                                                                <?php 
                                                                            } 
                                                                            foreach($addressResult as $row) { 
                                                                                foreach ($value as $sub_key => $sub_val) {
                                                                                    if($sub_key == 'delivery_address_id'){
                                                                                        if ($sub_val == $row['id']) {?>
                                                                                            <div class="product-container addressCard" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);width: 270px;margin: 10px auto;padding: 10px 10px;text-align: left;background-color: #e9ecef;cursor: pointer;position: relative;border-radius: 10px;">
                                                                                                <label class="clickable" style="position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;border-radius: 10px;transition: all ease .5s;z-index: 1;border-color: #ee4266;box-shadow: 0px 0px 6px 2px #ee4266;"><span class="checked-box" style="position: absolute;top: 0px;right: 0px;width: 22px;height: 22px;border-radius: 5px;background-color: #ee4266;color: #fff;text-align: center;display: block;">&#10004;</span></label>
                                                                                                <p class="address" style="color: #000;font-size: 14px;word-wrap: break-word;">
                                                                                                    <?php echo $row['first_name'].' '.$row['last_name'].', '.$row['phone_number'].', '.$row['address_line_1'].", ".$row['city'].", ".$row['country'].", ".$row['post_code']; ?>
                                                                                                </p>
                                                                                            </div>
                                                                                            <?php 
                                                                                        }
                                                                                    }
                                                                                }
                                                                            } 
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="margin: 10px auto;">
                                                                    <div class="col-sm-12" style="margin: 10px auto;">
                                                                        <?php 
                                                                            foreach ($value as $sub_key => $sub_val) {
                                                                                if($sub_key == "total") { ?>
                                                                                    <p class="property" style="color: #ee4266;font-size: 13px;">Delivery within 5-7 working days (<?php if($sub_val < 35.00){?>£4.99<?php } else {?>FREE<?php } ?>)</p>
                                                                                    <?php 
                                                                                } 
                                                                            } 
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php 
                                                            }
                                                        }
                                                    ?>
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

                                            <?php if(!isset($_SESSION['discount']) ){ ?>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">

                                                £<?php echo get_total($db);?>
                                            </span>

                                            <?php } else if(isset($_SESSION['discount']) ){ ?>
                                            <span class="amount linethrough" style="-webkit-text-decoration-line: line-through;text-decoration-line: line-through;text-decoration-color: #ee4266;text-decoration-thickness: 2px;color: #494f54;margin-left: 10px;font-weight: 600;">

                                                £<?php echo get_total($db);?>
                                            </span>
                                            <?php } ?>

                                        </div>
                                        <?php if(isset($_SESSION['discount']) ){ ?>

                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="property" style="color: #ee4266;font-size: 13px;">
                                                <?php 
                                                        $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $_SESSION['discount'])->fetchArray();
                                                        if ($discount['discount_type'] == '%TAGE') {
                                                            echo $discount["description"]." ".$discount["discount_value"].'% discount';
                                                        } else if ($discount['discount_type'] == 'AMOUNT') {
                                                            echo $discount["description"]." ".'£'.$discount["discount_value"].' discount';
                                                        }
                                                        ?>
                                            </span>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo get_discount_total($db);?></span>

                                        </div>
                                        <?php  }?>

                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Gift Message:</span>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo get_gift_message_charges($db);?></span>
                                        </div>
                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Delivery:</span>
                                            <span class="amount" style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo get_delivery_charges($db);?></span>
                                        </div>
                                        <div class="subtotal" style="padding: 15px;text-align: center;color: #212529;border-bottom: 1px solid #dee2e6;text-transform: uppercase;letter-spacing: 1px;font-size: 14px;font-weight: 400;display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: space-between;">
                                            <span class="label">Total:</span>
                                            <span class="amount " style="color: #494f54;margin-left: 10px;font-weight: 600;">£<?php echo get_grand_total($db);?></span>
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
