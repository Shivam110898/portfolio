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


//populate edit fields with existing value
if(isset($_GET['id'])){
    $id = FormatInput($_GET['id']); 
    $fetchedAddress = $db->query('SELECT * FROM user_address where id = ?', $id)->fetchArray();
}
include_once $root . "/views/header.php";
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Edit Address</div>
            </div>
            <div class="col-md-8">
                <form method="post" id="updateAddress">

                    <div class="p-3 p-lg-5 border">
                    <input id="id" name="id" type="hidden" value="<?php echo $fetchedAddress['id']; ?>">       
                    <input  name="userid" type="hidden" value="<?php echo $fetchedAddress['userid']; ?>">       
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="recipient_firstname"
                                    class="text-black">Recipient First Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="<?php echo $fetchedAddress['first_name']; ?>"
                                    name="urecipient_firstname" required>
                            </div>
                            <div class="col-md-12">
                                <label for="recipient_lastname" class="text-black">Recipient
                                    Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="<?php echo $fetchedAddress['last_name']; ?>"
                                    name="urecipient_lastname" required>
                            </div>
                            <div class="col-md-12">
                                <label for="recipient_number" class="text-black">Recipient
                                    Telephone<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" value="<?php echo $fetchedAddress['phone_number']; ?>"
                                    name="urecipient_number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="addressline1" class="text-black">Address Line 1<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="uaddressline1" name="uaddressline1"  value="<?php echo $fetchedAddress['address_line_1']; ?>"required>
                            </div>
                            <div class="col-md-6">
                                <label for="addressline2" class="text-black">Address Line 2
                                </label>
                                <input type="text" class="form-control" id="uaddressline2" name="uaddressline2" value="<?php echo $fetchedAddress['address_line_2']; ?>" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="city" class="text-black">City/Town<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city"  value="<?php echo $fetchedAddress['city']; ?>"required>
                            </div>
                            <div class="col-md-6">
                                <label for="postcode" class="text-black">Post Code</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" value="<?php echo $fetchedAddress['post_code']; ?>">
                                <div id="invalidPostCodeAlert" class="alert">
                                                            <span class="closebtn">&times;</span>  
                                                            <strong>Please enter a valid UK address.</strong> 
                                                        </div>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn  btn-pink btn-block"
                                    onclick="return UpdateAddress();" value="Save">
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