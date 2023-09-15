<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["CUSTOMER_LOGIN"]) || $_SESSION["CUSTOMER_LOGIN"] === '') {
    header("location: /views/logout.php");
    exit;
}


$profileResult = $db->query('SELECT * FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();

include_once $root . "/views/header.php";
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Add Address</div>
            </div>
            <div class="col-md-8">
                <form action="#" method="post" id="addAddress">
                <input id="id" name="id" type="hidden" value="<?php echo $profileResult['id']; ?>">       

                    <div class="p-3 p-lg-5 border">
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="addressline1" class="text-black">Address Line 1<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="addressline1" name="addressline1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="addressline2" class="text-black">Address Line 2
                                </label>
                                <input type="text" class="form-control" id="addressline2" name="addressline2" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="city" class="text-black">City/Town<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-6">
                                <label for="postcode" class="text-black">Post Code</label>
                                <input type="text" class="form-control" id="postcode" name="postcode">
                                <div id="invalidPostCodeAlert" class="alert">
                                                            <span class="closebtn">&times;</span>  
                                                            <strong>Please enter a valid UK address.</strong> 
                                                        </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn  btn-pink btn-block"
                                    onclick="return AddAddress();" value="Save">
                            </div>
                        </div>

                    </div>
                </form>
                </div>

            <div class="col-md-4 ml-auto">
            <?php include_once $root . "/views/customermenu.php";?>

            </div>
        </div>
    </div>
</div>

<?php
    include_once $root . "/views/footer.php";
    ?>