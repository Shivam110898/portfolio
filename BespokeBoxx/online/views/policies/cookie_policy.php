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
                <div class="site-section-heading">Cookie Policy</div>
            </div>
            <div class="col-md-12">
            <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">INFORMATION ABOUT OUR USE OF COOKIES </span>
                    <p class="mb-0">Welcome to BespokeBoxx.co.uk (‘Site’). Our website uses cookies to distinguish you
                        from other users of our website. This helps us to provide you with a good experience when you
                        browse our website and also allows us to improve our Site. Here you will find information on
                        what cookies may be set when you visit our Site and the purpose for which we use those cookies.
                        The Site is owned and operated by BespokeBoxx (‘we’, ‘our’, ‘us’ as applicable). For further
                        detailed information about this Site, please check here to see our Privacy Policy.

                        <br><br>By continuing to use this Site, you are agreeing to our use of cookies in the manner
                        described
                        in this policy. We may make changes to this Cookie Policy at any time by sending you an e-mail
                        with the modified Terms or by posting a copy of them on the Site. Any changes will take effect
                        14
                        days after the date of our email or the date on which we post the modified terms on the Site,
                        whichever is the earlier. Your continued use of the Site after that period expires means that
                        you agree to be bound by the modified policy.</p>
                </div>


            </div>
            <div class="col-md-12">
            <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">WHAT ARE COOKIES?</span>
                    <p class="mb-0">Cookies are text files with small pieces of data — like a username and password —
                        that are used to identify your computer as you use a computer network. Specific cookies known as
                        HTTP cookies are used to identify specific users and improve your web browsing experience.
                    </p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">DIFFERENT TYPES OF COOKIES</span>
                    <p class="mb-0">
                        With a few variations, cookies come in two types: session and persistent.<br>

                        <br>Session cookies are used only while navigating a website. They are stored in random access
                        memory and are never written to the hard drive.

                        When the session ends, session cookies are automatically deleted. They also help the "back"
                        button or third-party anonymizer plugins work. These plugins are designed for specific browsers
                        to work and help maintain user privacy.

                        <br><br>Persistent cookies remain on a computer indefinitely, although many include an
                        expiration date and are automatically removed when that date is reached. </p>
                </div>
            </div>
            <div class="col-md-12">
            <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">COOKIES WE USE</span>
                    <p class="mb-0">
                        If you create an account with us then we will use cookies for the management of the signup
                        process and general administration. These cookies will usually be deleted when you log out
                        however in some cases they may remain afterwards to remember your site preferences when logged
                        out.

                        <br><br>
                        We use cookies when you are logged in so that we can remember this fact. This prevents you from
                        having to log in every single time you visit a new page. These cookies are typically removed or
                        cleared when you log out to ensure that you can only access restricted features and areas when
                        logged in.
                        <br><br>
                        Cookies may be used to remember
                        if you have already visited the site and whether to show certain notifications which might only be
                        valid to visited/first time users.
                        <br><br>
                        This site offers e-commerce or payment facilities and some cookies are essential to ensure that
                        your order is remembered between pages so that we can process it properly.
                        <br><br>


                        In some special cases we also use cookies provided by trusted third parties. The following
                        section details which third party cookies you might encounter through this site.
                        <br><br>
                        This site uses Stripe which is one of the most widespread and trusted payment
                        gateways on the web to securely process your transactions. These cookies are used to provide a smooth and secure payment process.
                        <br><br>
                        For more information on Stripe cookies, see the official Stripe page.
                        <br><br>
                        
                        As we sell products it’s important for us to understand statistics about how many of the
                        visitors to our site actually make a purchase and as such this is the kind of data that these
                        cookies will track. This is important to you as it means that we can accurately make business
                        predictions that allow us to monitor our product costs to ensure the best
                        possible price.
                        

                    </p>
                </div>
            </div>

            <div class="col-md-6">
            <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">HOW TO CONTROL YOUR COOKIES?</span>
                    <p class="mb-0">
                        When you accessed the Site, you were presented with a message that notified you of our use of
                        cookies. We had to use a cookie to present you with that notice. If you continue to use the Site, more cookies
                        and other
                        tracking technologies will be placed on your computer as described in this Cookie Policy in
                        order to
                        enhance your user experience whilst on the Site. By continuing to use the Site and/or by
                        accepting
                        our Terms & Conditions, you are agreeing to the use of such cookies and tracking technology.
                        <br><br>
                        If you wish to restrict or block the cookies which are set by this Site (or, indeed, on any
                        other
                        site) you can do this through your browser settings. The ‘Help’ function within your browser
                        should
                        tell you how.
                        <br><br>
                        Please be aware that restricting cookies may mean that you will not be able to take full
                        advantage
                        of all the features or services available on this Site.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
            <div class="p-4  mb-3">
                    <span class="d-block text-primary h6 ">CONTACT US</span>
                    <p class="mb-0">
                        If you have any questions or concerns about cookies or your privacy when using this Site, please
                        contact us as follows:


                        <br><br>
                        By email at info@bespokeboxx.co.uk
                        <br><br>
                        By social media
                        <div class="icons">
                            <a href="https://www.facebook.com/bespokeboxx/" class="icons-btn d-inline-block"><span
                                    class="icon-facebook"></span></a>
                            <a href="https://www.instagram.com/bespokeboxx_/?hl=en"
                                class="icons-btn d-inline-block"><span class="icon-instagram"></span></a>
                            <a href="https://twitter.com/BespokeBoxx" class="icons-btn d-inline-block"><span
                                    class="icon-twitter"></span></a>
                        </div>

                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include_once $root . "/views/footer.php"; ?>