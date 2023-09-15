<?php
session_start();
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
                <div class="site-section-heading">CREATE ACCOUNT</div>
            </div>
            <div class="col-md-7">

                <form action="#" method="post" id="registerForm" >

                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtemail" class="text-black">Email<span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="txtemail" name="txtemail" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtemail" class="text-black">First name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtfirstname" name="txtfirstname" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtlastname" class="text-black">Last name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtlastname" name="txtlastname" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtpassword" class="text-black">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="txtpassword" minlength="6" name="txtpassword" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtconfirmpassword" class="text-black">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="txtconfirmpassword" minlength="6" name="txtconfirmpassword" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <span class="d-block text-primary h6 "><span class="text-danger">*</span> By creating an account you agree to our Terms of Service.</span>
                                <input type="submit" class="btn  btn-pink btn-block"  onclick="return UserRegister();" value="Register">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5 ml-auto">
            <a href="/views/policies/terms_&_conditions.php">
                    <div class="p-4 border-teal mb-3">
                        <span class="d-block text-primary h6 "><span class="text-danger">*</span> By creating an account you agree to our Terms of Service.</span>
                        <p class="mb-0">Find Terms & Conditions</p>
                    </div>
                </a>
                <a href="/views/login.php">
                    <div class="p-4 border-teal mb-3">
                        <span class="d-block text-primary h6 ">Already have an account yet?</span>
                        <p class="mb-0">Sign in</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</div>
<?php 
include $root . "/views/footer.php";
?>