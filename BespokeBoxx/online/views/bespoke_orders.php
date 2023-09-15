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
                <div class="site-section-heading">BESPOKE/CORPORATE ORDERS</div>
            </div>
            <div class="col-md-6">
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">If you would like a customised quotation for company BespokeBoxx's or can't find what you're looking for,
                         please send us a message using the form on this page.</span>
                </div>
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">How can BespokeBoxx help your business?</span>
                    <p class="mb-0">At BespokeBoxx we welcome bulk orders for customised corporate BespokeBoxx's.
                        We can accommodate most requests and are happy to fulfil on behalf of your business to
                        clients, staff, colleagues, companies or customers and can supply a bulk order.

                        We can personalise the BespokeBoxx with gift messages and in some cases, your logo.

                        At BespokeBoxx we aim to deliver your customised BespokeBoxx within 5-7 working days<a href="/views/policies/delivery_policy.php">(see our Delivery Policy)</a>, however Corporate/Bulk Orders will carry seperate lea times. Please contact us for further details.
                </div>

            </div>
            <div class="col-md-6">

                <form method="post">

                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="txtemail" class="text-black">First name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="message_firstname" required>
                            </div>
                            <div class="col-md-6">
                                <label for="txtlastname" class="text-black">Last name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="message_lastname" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtpassword" class="text-black">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="message_email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="txtconfirmpassword" class="text-black">Message <span
                                        class="text-danger">*</span></label>
                                <textarea type="text" class="form-control" name="message_details" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" class="btn  btn-pink btn-block" onclick="return SendEmailToBB();"
                                    value="Send Message">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php 
include $root . "/views/footer.php";
?>