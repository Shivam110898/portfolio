<?php
session_start();

if(isset($_SESSION['CUSTOMER_LOGIN'])){
	header('Location: /views/myaccount.php');
}

if(isset($_SESSION['GUEST_LOGIN'])){
	header('Location: /views/checkout.php');
}
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);
include_once $root . "/views/header.php";
  
?>

<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">SIGN IN</div>
            </div>
            <div class="col-md-7">
                <form >
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_fname" class="text-black">Email<span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Please enter the email used to create your account" name="email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_lname" class="text-black">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" placeholder="Please enter your password" name="password" required>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn  btn-pink btn-block" onclick="return UserLogin();" value="SIGN IN">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5 ml-auto">
                <a href="/views/register.php">
                    <div class="p-4 border-teal mb-3">
                        <span class="d-block text-primary h6 ">Don't have an account yet?</span>
                        <p class="mb-0">Create Account</p>
                    </div>
                </a>
                <a href="/views/password_recovery.php">

                    <div class="p-4 border-teal mb-3">
                        <span class="d-block text-primary h6 ">Forgotten your password?</span>
                        <p class="mb-0">Password Recovery</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<?php 
include $root . "/views/footer.php";
?>