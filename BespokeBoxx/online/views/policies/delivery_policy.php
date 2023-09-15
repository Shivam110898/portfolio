<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/helpers/Database.php";
require_once $root . "/helpers/config.php";
require_once $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);
include_once $root . "/views/header.php";

?>

<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Delivery & Returns</div>
            </div>
            <div class="col-md-12">
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">At BespokeBoxx we offer free delivery service if your
                        Boxx is £35.00 or more, otherwise you will be charged a small delivery fee if your order
                        doesn't satisfy the minimum order for free delivery. </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">Standard Delivery (£4.99)</span>
                    <p class="mb-0">At BespokeBoxx we aim to deliver your customised BespokeBoxx within 5-7 working days from the date of your order. </p>
                </div>
            </div>
            <div class="col-md-6">
            <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">Corporate orders</span>
                    <p class="mb-0">At BespokeBoxx we aim to deliver your customised BespokeBoxx within 5-7 working days <a href="/views/policies/delivery_policy.php">(see our Delivery Policy)</a>, however Corporate/Bulk Orders will carry seperate lead times. Please contact us for further details. </p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">Returns</span>
                    <p class="mb-0">You can return any BespokeBoxx to us (excluding BespokeBoxx's involving perishable items and customised items) within 30 days of the purchase date for a full refund
                        (excluding delivery charges). You must return the BespokeBoxx to the BespokeBoxx Office via postage along with a
                        receipt as proof of purchase and a refund will be made via the original method of payment. BespokeBoxx reserves the right not to refund if the products are deemed as not being in a resell-able
                        condition, if there is no proof of purchase, or if the products are returned after the 30 day
                        period. We aim to process all refunds within 14 working days. Please contact us at info@bespokeboxx.co.uk with your order details for further advice.</p>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include_once $root . "/views/footer.php"; ?>