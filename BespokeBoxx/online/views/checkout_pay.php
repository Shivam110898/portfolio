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
                    <li class="active" <?php if (isset($_SESSION["CUSTOMER_LOGIN"]) || isset($_SESSION["GUEST_LOGIN"])) { ?> onclick='return showSummary();'
                        <?php } ?>>Summary</li>
                    <li class="active">Pay</li>
                </ul>
                
            </div>
            <div class="col-md-12">
                <div id="paymentSection" class="panels">
                    <button class="accordion">Pay Now</button>

                    <div class="row">
                        <div class="col-sm-12">
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
                                    <Button class=" showSelection" onclick="return RemoveFromCart('1','Discount');">Remove</Button>
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
                            
                        </main>
                        <form id="payment-form">
                            <div id="card-element">
                                <!--Stripe.js injects the Card Element-->
                            </div>
                            <button id="submit">
                                <div class="spinner hidden" id="spinner"></div>
                                <span id="button-text">Pay £<?php echo get_grand_total($db); ?></span>
                            </button>
                            <p id="card-error" role="alert"></p>
                            
                        </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="/js/client.js"></script>
<?php include_once $root . "/views/footer.php";?>