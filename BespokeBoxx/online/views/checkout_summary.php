<?php
session_start();
if(!isset($_SESSION['boxxQuantity'])){
	header('Location: /index.php');
}
if(!isset($_SESSION["CUSTOMER_LOGIN"]) && !isset($_SESSION["GUEST_LOGIN"])){
	header('Location: /views/checkout.php');
}
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/helpers/Database.php";
require_once $root . "/helpers/config.php";
require_once $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);
unset($_SESSION['delivery_address_count']);
foreach ($_SESSION['Cart'] as $key => $value) {
    foreach ($value as $sub_key => $sub_val) {
        if($sub_key == "delivery_address_id") {    
            $_SESSION['delivery_address_count']++;
        } 
    }
}
foreach ($_SESSION['botmBoxx'] as $key => $value) {
    foreach ($value as $sub_key => $sub_val) {
        if($sub_key == "delivery_address_id") {    
            $_SESSION['delivery_address_count']++;
        } 
    }
}
$profileResult;
if (isset($_SESSION["CUSTOMER_LOGIN"])) {
    $profileResult = $db->query('SELECT * FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();
    $addressResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted = ? ORDER BY created_at desc ', $profileResult['id'],'0' )->fetchAll();
    if (count($addressResult)==0 || count($_SESSION['Cart']) == 0){
        foreach ($_SESSION['Cart'] as $key => $value) {
            foreach ($value as $sub_key => $sub_val) {
                if($sub_key == "delivery_address_id") {    
                   unset($_SESSION['Cart'][$key]['delivery_address_id']);
                } 
            }
        }
    }
    if (count($addressResult)==0 || count($_SESSION['botmBoxx']) == 0){
        foreach ($_SESSION['botmBoxx'] as $key => $value) {
            foreach ($value as $sub_key => $sub_val) {
                if($sub_key == "delivery_address_id") {    
                   unset($_SESSION['botmBoxx'][$key]['delivery_address_id']);
                } 
            }
        }
    }
} else if(isset($_SESSION["GUEST_LOGIN"])){
    $profileResult = $db->query('SELECT * FROM user where id = ?', $_SESSION['GUEST_LOGIN'])->fetchArray();
    $addressResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted = ? ORDER BY created_at desc ', $profileResult['id'],'0' )->fetchAll();
    if (count($addressResult)==0 || count($_SESSION['Cart']) == 0 ){
        foreach ($_SESSION['Cart'] as $key => $value) {
            foreach ($value as $sub_key => $sub_val) {
                if($sub_key == "delivery_address_id") {    
                   unset($_SESSION['Cart'][$key]['delivery_address_id']);
                } 
            }
        }
    }
    if (count($addressResult)==0 || count($_SESSION['botmBoxx']) == 0){
        foreach ($_SESSION['botmBoxx'] as $key => $value) {
            foreach ($value as $sub_key => $sub_val) {
                if($sub_key == "delivery_address_id") {    
                   unset($_SESSION['botmBoxx'][$key]['delivery_address_id']);
                } 
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>BespokeBoxx &mdash; You Design, We Deliver.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
    <meta name="google-site-verification" content="OaK8ZF1o7huU1KNp8SPXkbwxleeKhJqilcvCZa4E_nw" />
    <link rel="icon" href="/images/Logo.png">
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700">
    <link rel="stylesheet" href="/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/magnific-popup.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/aos.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/script.js"></script>
    <script src="/js/checkout.logic.js"></script>

</head>

<body>

    <div class="site-wrap">
        <div class="site-navbar bg-white ">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="/index.php" class="js-logo-clone"><img src="/images/Logo.png"></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="site-section" data-aos="fade-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="site-section-heading">Secure Checkout</div>
                    </div>
                    <div class="col-md-12">
                        <ul id="progress-bar" class="checkoutbar">
                            <li class="active" onclick="return showAccount();">Account</li>
                            <li class="active"
                                <?php
                                if (isset($_SESSION["CUSTOMER_LOGIN"]) || isset($_SESSION["GUEST_LOGIN"])) { ?>
                                onclick='return showSummary();' <?php } ?>>Summary</li>
                            <li <?php if($_SESSION['delivery_address_count'] == count($_SESSION['boxxQuantity'] )){?>
                                onclick="return showPay();" <?php } ?>>Pay</li>
                        </ul>

                    </div>
                    <div class="col-md-12">
                        <div id="summarySection" class="panels">
                            <button class="accordion">Order Summary</button>

                            <div class="row">

                                <div class="col-sm-12">
                                    <?php
                                    if (isset($_SESSION["CUSTOMER_LOGIN"])) {
                                        echo "<h2>Hi ".$profileResult['first_name'].", please review your order summary.</h2>";
                                    } else if(isset($_SESSION["GUEST_LOGIN"])){
                                        echo "<h2>Hi ".$profileResult['email']." <Button class='link-button ' onclick='return ChangeGuestEmail();' >Edit</Button>  please review your order summary.</h2>";
                                    }
                                ?>
                                </div>

                                <div class="col-sm-12">
                                    <?php  if($_SESSION['delivery_address_count'] < $_SESSION['boxxQuantity']){?>
                                    <div  class="display-alert">
                                        <strong>Please add recipient delivery details for each of your Boxxes.</strong> 
                                    </div>                   
                                    <?php  }?>                 
                                   
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <?php 
                                                $counter = 0;
                                                foreach ($_SESSION['Cart'] as $key => $value) {
                                                    $counter++; ?>
                                                    <div class="shopping-card width_setter" data-aos="fade-left">
                                                        <div class="col-sm-12">
                                                            <h2 class="boxcount"><span class="count"><?php echo "#".$counter; ?></span></h2>
                                                            <Button class="btnn-right-top showSelection "
                                                                onclick="return RemoveFromCart('<?php echo $key;?>', 'Boxx');">Remove</Button>
                                                            <Button class="btnn-left-top showSelection "
                                                                onclick="return EditHamper('<?php echo $key;?>');">Edit</Button>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <?php
                                                                        foreach ($value as $sub_key => $sub_val) {
                                                                            if (is_array($sub_val)) { 
                                                                                foreach ($sub_val as $k => $v) {
                                                                                    if($sub_key == "colour") {
                                                                                        $getBoxxColour = $db->query('SELECT id, name, image FROM products where id=?', $k)->fetchArray();
                                                                                        $image_src = "/uploadedimgs/" . $getBoxxColour["image"];
                                                                                        echo "<img class='basketImg' src='".$image_src."'>"; 
                                                                                    } 
                                                                                } 
                                                                                foreach ($sub_val as $k => $v) {
                                                                                    if($sub_key == "filling") {

                                                                                        $getBoxxFillinng = $db->query('SELECT id, name, image FROM products where id=?', $k)->fetchArray(); 
                                                                                        $image_src = "/uploadedimgs/" . $getBoxxFillinng["image"];
                                                                                        echo "<img class='basketImg' src='".$image_src."'>";   
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
                                                            <div class="row">
                                                                <div class="col">
                                                                    <?php 
                                                                            foreach ($value as $sub_key => $sub_val) {
                                                                                if (is_array($sub_val)) { 
                                                                                    foreach ($sub_val as $k => $v) {
                                                                                        if($sub_key == "products") {
                                                                                            $getItems = $db->query('SELECT name, price,image FROM products where id=?', $k)->fetchArray();
                                                                                            $image_src = "/uploadedimgs/" . $getItems["image"]; ?>
                                                                    <div class='table-responsive'>
                                                                        <table class='table table-borderless'>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><?php  echo "<img class='basketImg' src='".$image_src."'>"; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="property">
                                                                                            <?php echo $getItems["name"]; ?>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="property">X<?php echo $v; ?>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p class="property">
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
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <?php 
                                                                        foreach ($value as $sub_key => $sub_val) {
                                                                            if($sub_key == "total") { ?>
                                                                            <p class="price">Boxx Total (exl delivery) : £<?php echo $sub_val;  ?></p>
                                                                                <?php 
                                                                            } 
                                                                        } 
                                                                    ?>
                                                                    <Button class="btn-block showSelection" onclick="window.location.href='/views/checkout_delivery_form.php?boxxrid=<?php echo $key; ?>&type=bespoke';">Add Delivery Details</Button>
                                                                    <Button class="btn-block showSelection"onclick="return ShowModal('addGiftMessage<?php echo $key; ?>');">Add Message (Optional +£1.49)</Button>
                                                                    <?php 
                                                                        foreach ($value as $sub_key => $sub_val) {
                                                                            if($sub_key == 'gift_message'){  ?>
                                                                    <p class="recipient_tag">Gift Message: </p>

                                                                    <div class="product-container addressCard">
                                                                        <button
                                                                            onclick="RemoveFromCart('<?php echo $key; ?>','GiftmessageForBoxx');"
                                                                            class='showSelection btnn-right-top'>
                                                                            <span class='icon-close'></span>
                                                                        </button>
                                                                        <input name="AddressRadio" type="radio" hidden>

                                                                        <label class="clickable"><span
                                                                                class="checked-box">&#10004;</span></label>
                                                                        <p class="address"><?php echo $sub_val; ?></p>
                                                                    </div>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    
                                                                        $addressResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted = ? ORDER BY created_at desc ', $profileResult['id'],'0' )->fetchAll();
                                                                        if(count($addressResult)>0){?>
                                                                    <p class="recipient_tag">Select Recipient Delivery Details:
                                                                    </p>
                                                                    <?php 
                                                                        } 
                                                                        foreach($addressResult as $row) { ?>
                                                                    <div class="product-container addressCard"
                                                                        onclick="return SaveDeliveryAddress('<?php echo $row['id']; ?>', '<?php echo $key; ?>','bespoke');">
                                                                        <input id="<?php echo $row['id'].$key; ?>"
                                                                            name="AddressRadio" type="radio" hidden>
                                                                        <?php 
                                                                                    foreach ($value as $sub_key => $sub_val) {
                                                                                        if($sub_key == 'delivery_address_id'){
                                                                                            if ($sub_val == $row['id']) {?>
                                                                        <label class="clickable"><span
                                                                                class="checked-box">&#10004;</span></label>

                                                                        <?php 
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                        <p class="address">
                                                                            <?php echo $row['first_name'].' '.$row['last_name'].', '.$row['phone_number'].', '.$row['address_line_1'].", ".$row['city'].", ".$row['country'].", ".$row['post_code']; ?>
                                                                        </p>
                                                                    </div>

                                                                    <?php 
                                                                        }
                                                                        ?>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <?php 
                                                                            foreach ($value as $sub_key => $sub_val) {
                                                                                if($sub_key == "total") { ?>
                                                                    <p class="property">Delivery within 5-7 working days (<?php if($sub_val < 35.00){?>£4.99<?php } else {?>FREE<?php } ?>)</p>
                                                                    <?php 
                                                                                } 
                                                                            } 
                                                                        ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="addGiftMessage<?php echo $key; ?>" class="modal giftMessageModal">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span
                                                                    onclick="return HideModal('addGiftMessage<?php echo $key; ?>');"
                                                                    class="close closeGiftModal">&times;</span>
                                                            </div>
                                                            <form>
                                                            <input name="boxx_id" type="hidden" value="<?php echo $key; ?>">
                                                            <input name="type" type="hidden" value="bespoke">
                                                                <div class="form-group row">
                                                                    <div class="col-md-12">
                                                                        <textarea type="text" class="form-control"
                                                                            maxlength="100"placeholder="Enter gift message (max 100 characters)" name="giftMessage"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-12">
                                                                        <input type="submit" class="showSelection" onclick="return AddGiftMessage();" value="Add +£1.49">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                } 
                                                foreach ($_SESSION['botmBoxx'] as $key => $value) {
                                                    $counter++; ?>
                                                    <div class="shopping-card width_setter">
                                                        <div class="col">
                                                        <h2 class="boxcount"><span class="count"><?php echo "#".$counter; ?></span></h2>
                                                        <Button class=" btnn-right-top showSelection" onclick="return RemoveFromCart('<?php echo $key;?>', 'BOTM');">Remove</Button>
                                                            <?php 
                                                                foreach ($value as $sub_key => $sub_val) {
                                                                    if($sub_key == "productid") {
                                                                        $hotm = $db->query('SELECT name, price,image FROM products where id=?', $sub_val)->fetchArray();
                                                                        $image_src = "/uploadedimgs/" . $hotm["image"]; 
                                                                        $hotm_products = $db->query('SELECT * FROM product_properties where product_id = ? ', $sub_val)->fetchAll(); ?>
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <p class="property"><?php echo $hotm['name']; ?></p>
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
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                            <p class="price">Boxx Total (exl delivery) : £<?php echo $hotm['price']; ?></p>

                                                                                <Button class="btn-block showSelection" onclick="window.location.href='/views/checkout_delivery_form.php?boxxrid=<?php echo $key; ?>&type=hotm';">Add Delivery Details</Button>
                                                                                <Button class="btn-block showSelection"onclick="return ShowModal('addGiftMessagehotm<?php echo $key; ?>');">Add Message (Optional +£1.49)</Button>
                                                                               
                                                                                <?php 
                                                                                    foreach ($value as $sub_key => $sub_val) {
                                                                                        if($sub_key == 'gift_message'){  ?>
                                                                                            <p class="recipient_tag">Gift Message: </p>

                                                                                            <div class="product-container addressCard">
                                                                                                <button
                                                                                                    onclick="RemoveFromCart('<?php echo $key; ?>','GiftmessageForBOTM');"
                                                                                                    class='showSelection btnn-right-top'>
                                                                                                    <span class='icon-close'></span>
                                                                                                </button>
                                                                                                <input name="AddressRadio" type="radio" hidden>

                                                                                                <label class="clickable"><span
                                                                                                        class="checked-box">&#10004;</span></label>
                                                                                                <p class="address"><?php echo $sub_val; ?></p>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                
                                                                                    $addressResult = $db->query('SELECT * FROM user_address where user_id = ? AND is_deleted = ? ORDER BY created_at desc ', $profileResult['id'],'0' )->fetchAll();
                                                                                    if(count($addressResult)>0){ ?>
                                                                                        <p class="recipient_tag">Select Recipient Delivery Details:</p>
                                                                                        <?php 
                                                                                    } 
                                                                                    foreach($addressResult as $row) { ?>
                                                                                        <div class="product-container addressCard" onclick="return SaveDeliveryAddress('<?php echo $row['id']; ?>', '<?php echo $key; ?>','hotm');">
                                                                                            <input id="<?php echo $row['id'].$key; ?>" name="AddressRadio" type="radio" hidden>
                                                                                            <?php 
                                                                                                foreach ($value as $sub_key => $sub_val) {
                                                                                                    if($sub_key == 'delivery_address_id'){
                                                                                                        if ($sub_val == $row['id']) {?>
                                                                                                            <label class="clickable"><span class="checked-box">&#10004;</span></label>
                                                                                                            <?php 
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            <p class="address"><?php echo $row['first_name'].' '.$row['last_name'].', '.$row['phone_number'].', '.$row['address_line_1'].", ".$row['city'].", ".$row['country'].", ".$row['post_code']; ?></p>
                                                                                        </div>

                                                                                        <?php 
                                                                                    }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                            <?php 
                                                                                foreach ($value as $sub_key => $sub_val) {
                                                                                    if($sub_key == "total") { ?>
                                                                                        <p class="property">Delivery within 5-7 working days (<?php if($sub_val < 35.00){?>£4.99<?php } else {?>FREE<?php } ?>)</p>
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
                                                    <div id="addGiftMessagehotm<?php echo $key; ?>" class="modal giftMessageModal">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span onclick="return HideModal('addGiftMessagehotm<?php echo $key; ?>');" class="close closeGiftModal">&times;</span>
                                                            </div>
                                                            <form>
                                                            <input name="boxx_id" type="hidden" value="<?php echo $key; ?>">
                                                            <input name="type" type="hidden" value="hotm">
                                                                <div class="form-group row">
                                                                    <div class="col-md-12">
                                                                        <textarea type="text" class="form-control" maxlength="200"placeholder="Enter gift message (max 200 characters)" name="giftMessage"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row ">
                                                                    <div class="col-lg-12">
                                                                        <input type="submit" class="showSelection" onclick="return AddGiftMessage();" value="Add +£1.49">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                } 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="subtotal">
                                        <main class="totals">
                                            <div class="subtotal">

                                                <span class="label">Subtotal: </span>

                                                <?php if(!isset($_SESSION['discount']) ){ ?>
                                                <span class="amount">

                                                    £<?php echo get_total($db);?>
                                                </span>

                                                <?php } else if(isset($_SESSION['discount']) ){ ?>
                                                <span class="amount linethrough">

                                                    £<?php echo get_total($db);?>
                                                </span>
                                                <?php } ?>

                                            </div>
                                            <div class="subtotal">

                                                <?php if(!isset($_SESSION['discount']) ){ ?>

                                                <form id="discounForm">
                                                    <div class="form-group row">
                                                        <div class="col">

                                                            <input type="text" name="discount_code" class="form-control"
                                                                placeholder="Promo Code" required>
                                                        </div>


                                                        <div class="col">
                                                            <input type="submit" class="btn-block showSelection"
                                                                onclick="return AddDiscount();" value="Apply">
                                                        </div>
                                                    </div>
                                                </form>

                                                <?php  } else if(isset($_SESSION['discount']) ){ ?>
                                                <span class="property">

                                                    <?php 
                                                    $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $_SESSION['discount'])->fetchArray();
                                                    if ($discount['discount_type'] == '%TAGE') {
                                                        echo $discount["description"]." ".$discount["discount_value"].'% discount';
                                                    } else if ($discount['discount_type'] == 'AMOUNT') {
                                                        echo $discount["description"]." ".'£'.$discount["discount_value"].' discount';
                                                    }
                                                    ?>
                                                    <Button class=" showSelection"
                                                        onclick="return RemoveFromCart('1','Discount');">Remove</Button>
                                                </span>
                                                <span class="amount">£<?php echo get_discount_total($db);?></span>
                                                <?php  }?>

                                            </div>
                                            <div class="subtotal">
                                                <span class="label">Gift Message:</span>

                                                <span class="amount ">
                                                    £<?php echo get_gift_message_charges($db);?>
                                                </span>
                                            </div>
                                            <div class="subtotal">
                                                <span class="label">Delivery:</span>

                                                <span class="amount ">
                                                    £<?php echo get_delivery_charges($db);?>
                                                </span>
                                            </div>
                                            <div class="subtotal">
                                                <span class="label">Total:</span>

                                                <span class="amount ">
                                                    £<?php echo get_grand_total($db);?>
                                                </span>
                                            </div>

                                            <button class="btn btn-block btn-primary" onclick="return showPay();" <?php  if($_SESSION['delivery_address_count'] < $_SESSION['boxxQuantity']){?> disabled <?php }  ?>>Pay Now</button>

                                        </main>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
          
 <?php include_once $root . "/views/footer.php"; ?>