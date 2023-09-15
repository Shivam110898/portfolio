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
        <div class="header">
            <div class="row">
                <div class="col">
                    <div class="site-section-heading">The Boxx</div>
                </div>
                <div class="col">
                    <select id="sort" onchange="LoadProducts(this.value,3);">
                    <option value="new">Sort by</option>
                    <option value="new">Newest</option>
                        <option value="high">Price (High - Low)</option>
                        <option value="low">Price (Low - High)</option>
                    </select>
                </div>
                <div class="col">
                    <?php if(isset($_SESSION['boxxcolour'])) {
                        ?>
                    <a href="/views/buildyourbespokeboxx.php" class="btn btn-pink ">View Your Boxx</a>
                    <?php } else { ?>
                    <a href="/views/buildyourbespokeboxx.php" class="btn btn-pink ">Build Your Boxx</a>
                    <?php } ?>

                </div>
            </div>

        </div>
        
        <div id="Products" class="row">
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                LoadProducts("old", 3);
            });
        </script>
    </div>
</div>
<?php include_once $root . "/views/footer.php"; ?>