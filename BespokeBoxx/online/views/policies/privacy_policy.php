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
                <div class="site-section-heading">Privacy Policy</div>
            </div>
            <div class="col-md-12">
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">BespokeBoxx Privacy Policy</span>
                    <p class="mb-0">

                        This Privacy Policy describes how your personal information is collected, used, and shared when
                        you visit or make a purchase from https://www.bespokeboxx.co.uk/ (the “Site”).<br><br>

                        PERSONAL INFORMATION WE COLLECT<br><br>

                        In order to complete your purchases with us (BespokeBoxx) we may require you to provide us with some basic details
                        such as name, email, delivery address, etc. <br><br>
                        
                        We do not store any payment information entered on this site (BespokeBoxx).<br><br>

                        When you visit the Site, we automatically collect certain information about your device,
                        including information about your web browser, IP address, time zone, and some of the cookies
                        that are installed on your device. Additionally, as you browse the Site, we collect information
                        about the individual web pages or products that you view, what websites or search terms referred
                        you to the Site, and information about how you interact with the Site. We refer to this
                        automatically-collected information as “Device Information.”<br><br>

                        We collect Device Information using the following technologies:<br><br>
                        Cookies are data files that are placed on your device or computer and often include an
                        anonymous unique identifier. For more information about cookies, and how to disable cookies,
                        visit http://www.allaboutcookies.org .<br><br>
                        <a href="/views/policies/cookie_policy.php">Please see our Cookie Policy</a><br><br>

                        HOW DO WE USE YOUR PERSONAL INFORMATION?<br><br>

                        We use the Order Information that we collect generally to fulfill any orders placed through the
                        Site (including processing your payment information, arranging for shipping, and providing you
                        with invoices and/or order confirmations). Additionally, we use this Order Information to:
                        Communicate with you; Screen our orders for potential risk or fraud; and
                        When in line with the preferences you have shared with us, provide you with information or
                        advertising relating to our products or services.<br>
                        We use the Device Information that we collect to help us screen for potential risk and fraud (in
                        particular, your IP address), and more generally to improve and optimize our Site (for example,
                        by generating analytics about how our customers browse and interact with the Site, and to assess
                        the success of our marketing and advertising campaigns).<br><br>
                        

                        YOUR RIGHTS<br><br>
                        If you are a European resident, you have the right to access personal information we hold about
                        you and to ask that your personal information be corrected, updated, or deleted. If you would
                        like to exercise this right, please contact us through the contact information
                        below.Additionally, if you are a European resident we note that we are processing your
                        information in order to fulfill contracts we might have with you (for example if you make an
                        order through the Site), or otherwise to pursue our legitimate business interests listed above.<br><br>


                        DATA RETENTION<br><br>
                        When you place an order through the Site, we will maintain your Order Information for our
                        records unless and until you ask us to delete this information.<br><br>

                        Please note we will store all data provided to us for a period of 12 months after the dispatch date for auditing & analytics purposes to provide you with a great user experience.
                        You can ask to delete your details either by contacting us or if you have an account by using the Delete Your account
                        button.<br><br>

                        CHANGES<br><br>
                        We may update this privacy policy from time to time in order to reflect, for example, changes to
                        our practices or for other operational, legal or regulatory reasons.<br><br>
                        
                        CONTACT US<br><br>
                        For more information about our privacy practices, if you have questions, or if you would like to
                        make a complaint, please contact us by e-mail at info@bespokeboxx.co.uk.

                </div>


            </div>


        </div>
    </div>
</div>
<?php include_once $root . "/views/footer.php"; ?>