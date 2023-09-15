<?php
session_start();
if(!isset($_SESSION['boxxQuantity'])){
	header('Location: /index.php');
}
if(isset($_SESSION['CUSTOMER_LOGIN']) || isset($_SESSION['GUEST_LOGIN']) ){
	header('Location: /views/checkout_summary.php');
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
    <script src="/js/checkout_account.js"></script>

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
                    <li <?php if (isset($_SESSION["CUSTOMER_LOGIN"]) || isset($_SESSION["GUEST_LOGIN"])) { ?> onclick='return showSummary();'
                        <?php } ?>>Summary</li>
                    <li>Pay</li>
                </ul>
                
            </div>
            <div class="col-md-12">
                <div id="accountSection" class="panels">
                    <button class="accordion">Account Details</button>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab">
                                <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Guest')">Guest</button>

                                <button class="tablinks" onclick="openTab(event, 'Login')">Login</button>

                                <button class="tablinks" onclick="openTab(event, 'Create')">Create Account</button>
                            </div>
                            <div id="Login" class="tabcontent">
                                <form>

                                    <div class="p-3 p-lg-5 border">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="email"  class="text-black">Email<span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="password" class="text-black">Password <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" name="password" required>
                                            </div>

                                        </div>
                                        <div id="guestEmailAlert" class="alert ">
                                            <strong>This email is already registered to an account, please sign in.</strong> 
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <input type="submit" onclick="return UserLoginFromCheckout();"
                                                    class="btn  btn-pink btn-block" value="SIGN IN">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="Guest" class="tabcontent">
                                <form action="#" method="post" id="guestLogin">
                                    <div class="p-3 p-lg-5 border">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="email" class="text-black">Email<span class="text-danger">*</span></label>
                                                <span class="d-block text-primary h6 "><span class="text-danger">*</span> By continuing as a Guest you agree to our Terms of Service.</span>
                                                <input type="email" class="form-control" id="loginEmail" name="guestLoginEmail" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <input type="submit" class="btn  btn-pink btn-block" onclick="return ContinueAsGuest();" value="Continue">
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div id="Create" class="tabcontent">
                                <form action="#" method="post" id="createAccount">

                                    <div class="p-3 p-lg-5 border">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="txtemail" class="text-black">First name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="txtfirstname"
                                                    name="txtfirstname" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="txtlastname" class="text-black">Last name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="txtlastname"
                                                    name="txtlastname" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label for="txtemail" class="text-black">Email<span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="txtemail" name="txtemail"
                                                    required>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="txtpassword" class="text-black">Password <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="txtpassword" minlength="6"
                                                    name="txtpassword" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="txtconfirmpassword" class="text-black">Confirm Password
                                                    <span class="text-danger">*</span></label>
                                                <input type="password" class="form-control" id="txtconfirmpassword" minlength="6"
                                                    name="txtconfirmpassword" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="acceptTerms" class="text-black">By creating an account you
                                                    accept our Terms & Conditions<span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <input type="submit" class="btn  btn-pink btn-block"
                                                    onclick="return UserRegisterFromCheckout();" value="Register">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
<?php include_once $root . "/views/footer.php";
    ?>