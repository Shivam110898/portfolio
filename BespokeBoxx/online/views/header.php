<!DOCTYPE html>
<html lang="en">

<head>
  <title>BespokeBoxx - For Any Occasion | Build Your BespokeBoxx </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="google-site-verification" content="OaK8ZF1o7huU1KNp8SPXkbwxleeKhJqilcvCZa4E_nw" />
  <meta name="description" content="BespokeBoxx Hampers for any occasion. Just Build Your BespokeBoxx & we'll take care of the rest.">
    <link rel="icon" href="/images/Logo.png">
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/magnific-popup.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/aos.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/syh.js"></script>
    <script src="/js/script.js"></script>
</head>
<body>
    <div class="site-wrap">
        <div class="site-navbar bg-white ">
            <div class="search-wrap">
                <div class="container-fluid">
                    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
                    <form  role="form" method="post">
                        <div class="form-group ajax-search">
                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search...">
                            <ul id="content"></ul>
                        </div>

                    </form>
                </div>
            </div>
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="/index.php" class="js-logo-clone"><img src="/images/Logo.png" alt="BespokeBoxx logo"></a>
                        </div>
                    </div>
                    <div class="main-nav d-none d-lg-block">
                        <nav class="site-navigation text-right text-md-center" role="navigation">
                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                <li class="startbtn">
                                    <?php if(isset($_SESSION['boxxcolour'])) {
                                            ?>
                                    <a href="/views/buildyourbespokeboxx.php">View Your Boxx</a>
                                    <?php } else { ?>
                                    <a href="/views/buildyourbespokeboxx.php ">Build Your Boxx</a>
                                    <?php } ?>
                                </li>
                                <li><a href="/views/productCategories/theboxx.php">The Boxx</a></li>
                                <li><a href="/views/productCategories/beauty.php">Beauty & Care</a></li>
                                <li><a href="/views/productCategories/food_drink.php">Food & Drink</a></li>
                                <li><a href="/views/productCategories/home_gifts.php">Home & Leisure</a></li>
                                <li><a href="/views/productCategories/little_ones.php">Little Ones</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="icons" id="result">
                        <a href="#" class="icons-btn d-inline-block js-search-open"><span
                                class="icon-search"></span></a>
                        <?php  if (!isset($_SESSION["CUSTOMER_LOGIN"]) || $_SESSION["CUSTOMER_LOGIN"] === '') { ?>
                        <a href="/views/login.php" class="icons-btn d-inline-block"><span
                                class="icon-user-o"></span></a>
                        <?php } else if (isset($_SESSION["CUSTOMER_LOGIN"]) || $_SESSION["CUSTOMER_LOGIN"] != '')  { ?>

                        <a href="/views/myaccount.php" class="icons-btn d-inline-block"><span
                                class="icon-user-o"></span></a>

                        <?php } ?>

                        <a href="#" class="cart-button icons-btn d-inline-block bag"> <span
                                class="icon-shopping-bag"></span>
                            <?php if (isset($_SESSION["boxxQuantity"])) { ?>
                            <span class="number"><?php echo $_SESSION['boxxQuantity'];?></span>
                            <?php } ?>
                        </a>
                        <a href="#" class=" site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                                class="icon-menu"></span></a>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="promo-banner">
                <div class="row">
                    <div class="col-md-4">
                        <a href="/views/policies/delivery_policy.php">
                            <div class="promo">
                                <h1>FREE DELIVERY WHEN YOU SPEND OVER £35.00 ON YOUR BOXX</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/views/bespoke_orders.php">
                            <div class="promo">
                                <h1>BESPOKE/CORPORATE ORDERS</h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/views/hamper_fillings.php">
                            <div class="promo">
                                <h1>PICK UP TO 2 FREE BESPOKEBOXX FILLINGS</h1>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <aside id="sidebar-cart">
            <main>
                <a href="#" class="close-button"><span class="icon-close"></span></a>
                <h2>Your Cart<span class="count"><?php echo $_SESSION['boxxQuantity'];?></span></h2>
                <?php if (isset($_SESSION['Cart']) || isset($_SESSION['botmBoxx'])) { ?>
                    <div class="totals">
                        <div class="subtotal">

                            <span class="label">Subtotal (exl DELIVERY): </span>

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

                            <?php  }?>
                            <?php 
                                if(isset($_SESSION['discount']) ){ ?>
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
                        <div class="inline">
                            <button class="btn showSelection" onclick="showAccount(); ">Checkout</button>
                            <button class="btn showSelection" onclick="SetSideCartStatusToFalse(); showColour(); ">Build Another Boxx</button>
                            
                        </div>
                        <ul class="list-unstyled">
                            <img class="payment-methods-cart" src="/images/methods.png">
                            <img class="payment-methods-cart" src="/images/powered.png">

                        </ul>
                    </div>
                    <div class="cart-baskets">
                        <div class="row">
                            <?php 
                                $counter = 0;
                                foreach ($_SESSION['Cart'] as $key => $value) {
                                    $counter++; ?>
                                    <div class="shopping-card width_setter">
                                        <div class="col">
                                            <h2 class="boxcount"><span class="count"><?php echo "#".$counter; ?></span></h2>
                                            <Button class=" btnn-right-top showSelection "onclick="return RemoveFromCart('<?php echo $key;?>', 'Boxx');">Remove</Button>
                                            <Button class="btnn-left-top showSelection " onclick="return EditHamper('<?php echo $key;?>');">Edit</Button>
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
                                                                } ?>
                                                                <p class="property">
                                                                    <?php  
                                                                        foreach ($sub_val as $k => $v) {
                                                                            if($sub_key == "size") {
                                                                                $getBoxxSize = $db->query('SELECT id, name,image ,price FROM products where id=?', $k)->fetchArray();
                                                                                $getprops = $db->query('SELECT * FROM product_properties where product_id = ? AND property_name = ?', $k, 'Size')->fetchArray();
                                                                                echo $getBoxxSize["name"]. ", £".$getBoxxSize["price"]."<br> ".$getprops['property_value'] ; 
                                                                            } 
                                                                        }  
                                                                    ?>
                                                                </p>
                                                                <?php 
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
                                                                        $image_src = "/uploadedimgs/" . $getItems["image"];
                                                                         ?>
                                                                        <div class='table-responsive'>
                                                                            <table class='table table-borderless'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td><?php  echo "<img class='basketImg' src='".$image_src."'>"; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="property"><?php echo $getItems["name"]; ?></p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="property">X<?php echo $v; ?></p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p class="property">£<?php echo $getItems["price"]*$v; ?>
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
                                                </div>
                                                <div class="col">
                                                    <?php 
                                                        foreach ($value as $sub_key => $sub_val) {
                                                            if($sub_key == "total") { ?>
                                                                <p class="price">Boxx Total (exl delivery) : £<?php echo $sub_val; ?></p>
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
                                    $counter++;
                                    ?>
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
                                                            <div class="col">
                                                                <p class="price">Boxx Total (exl delivery) : £<?php echo $hotm['price']; ?></p>
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
                    </div>
                <?php } else {?>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="/views/buildyourbespokeboxx.php" class="btn btn-pink btn-block ">Build Your Boxx</a>
                    </div>
                </div>
                <?php } ?>
            </main>
        </aside>
        <div id="sidebar-cart-curtain"></div>
        <?php 
            if($_SESSION['sideCartVisible'] == true){ ?>
                <script>
                    $(document).ready(function () {
                        OpenSideCart();
                    });
                </script>
                <?php 
            }
        ?>