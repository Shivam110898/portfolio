<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

if(isset($_GET["token"])){
    $token = $_GET["token"];
    
} 
include_once $root . "/views/header.php";
?>

<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Change your Password</div>
                <form>
                    <div class="p-3 p-lg-5">
                    <input type="hidden" name="recoverytoken" value="<?php echo $token; ?>">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="recoverypassword" class="text-black">Enter new password.</label>
                                <input type="password" class="form-control" name="recoverypassword" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="recoveryconfirmpassword" class="text-black">Confirm new password.</label>
                                <input type="password" class="form-control" name="recoveryconfirmpassword" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-pink btn-block" onclick="return ChangePassword();"
                                    value="UPDATE PASSWORD">
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