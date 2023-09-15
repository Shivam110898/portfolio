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
            <div class="site-section-heading">Forgotten your password?</div>
                <form>
                    <div class="p-3 p-lg-5">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="email" class="text-black">Enter email associated with your account. You will receive a password recovery email.</label>
                                <input type="email" class="form-control"  name="recoveryemail"  required>
                            </div>
                            </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn  btn-pink btn-block"
                                    onclick="return PasswordRecovery();" value="Send Email">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    include_once $root . "/views/footer.php";
    ?>