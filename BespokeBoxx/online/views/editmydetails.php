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


$CustomerUser = $db->query('SELECT * FROM user_type WHERE role = ?', 'Customer')->fetchArray();

$profileResult = $db->query('SELECT * FROM user where email = ? and user_type_id = ? ', $_SESSION['CUSTOMER_LOGIN'], $CustomerUser['id'])->fetchArray();

include_once $root . "/views/header.php";
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Your Profile</div>
            </div>
            <div class="col-md-8">
                <form action="#" method="post" id="editCustomerForm">
                <input id="id" name="id" type="hidden" value="<?php echo $profileResult['id']; ?>">       

                    <div class="p-3 p-lg-5 border">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email" class="text-black">First name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $profileResult['first_name'];?> " >
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="text-black">Last name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $profileResult['last_name'];?>" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="email" class="text-black">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $profileResult['email'];?>" >
                            </div>
                           
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn  btn-pink btn-block"
                                    onclick="return EditCustomerDetails();" value="Save">
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