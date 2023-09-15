<?php
session_start();
if(!isset($_SESSION['boxxQuantity'])){
	header('Location: /index.php');
}
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/helpers/Database.php";
require_once $root . "/helpers/config.php";
require_once $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

$profileResult;
$boxxrid = $_GET['boxxrid'];
$type = $_GET['type'];
if (isset($_SESSION["CUSTOMER_LOGIN"])) {
    $profileResult = $db->query('SELECT * FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();
} else if(isset($_SESSION["GUEST_LOGIN"])){
    $profileResult = $db->query('SELECT * FROM user where id = ?', $_SESSION['GUEST_LOGIN'])->fetchArray();

}
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
    <script src="/js/address_autofill.js"></script>

</head>

<body>
    <div class="site-wrap">
        <div class="site-navbar bg-white ">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="/views/checkout_summary.php" class="js-logo-clone"><img src="/images/Logo.png"></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="site-section" data-aos="fade-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="site-section-heading">Please add recipient delivery details</div>
                        <span onclick="window.location.href='/views/checkout_summary.php'"
                            class="showSelection close">GO BACK &times;</span>
                    </div>
                    <div class="col-md-12">
                        <div class="panels">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div id="addressAlreadyExists" class="alert">
                                                    <strong>This recipient is already added, please select this
                                                        recipient from the options
                                                        provide on your Boxx in your summary, or add a new
                                                        recipient.</strong>
                                                </div>
                                                <label for="recipient_firstname" class="text-black">Recipient First
                                                    Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="recipient_firstname"
                                                    required>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="recipient_lastname" class="text-black">Recipient
                                                    Last Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="recipient_lastname"
                                                    required>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="recipient_number" class="text-black">Recipient
                                                    Telephone<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" minlength="11" name="recipient_number"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="card-container">
                                            <div class="panel">
                                                <span class="sb-title">Address Selection</span>
                                                <input name="userid" type="hidden"
                                                    value="<?php echo $profileResult['id']; ?>">
                                                <input name="boxx_id" type="hidden" value="<?php echo $boxxrid; ?>">
                                                <input name="type" type="hidden" value="<?php echo $type; ?>">
                                                <input type="text" name="addressline1" placeholder="Deliver to*" id="location" required />
                                                <input type="text" name="city" placeholder="City" id="postal_town"  required />
                                                <input type="text" name="postcode" placeholder="Zip/Postal code" id="postal_code" required />
                                                <input type="text" placeholder="Country" id="country"
                                                    value="United Kingdom" readonly required />
                                            </div>
                                            <div class="map" id="map"></div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <input type="submit" class=" showSelection btn-block"
                                                    onclick="return AddAddress();" value="Save">
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
        <script
            src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_API_KEY&libraries=places&callback=initMap&channel=GMPSB_addressselection_v1_cABC"
            async defer></script>
    </div>

    <script src="/js/jquery-ui.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <script src="/js/jquery.magnific-popup.min.js"></script>
    <script src="/js/aos.js"></script>
    <script src="/js/main.js"></script>

</body>

</html>