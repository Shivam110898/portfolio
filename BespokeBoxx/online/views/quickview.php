<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

include_once $root . "/views/header.php";
if (isset($_GET["productid"])) {
    $id =$_GET["productid"];
    $row = $db->query('SELECT * FROM products where id = ? ', $id)->fetchArray();
    $image = $row['image'];
 $image_src = "/uploadedimgs/" . $image;

}
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="header">
            <div class="site-section-heading"><?php echo $row["name"]; ?></div>
        </div>
        <div class="row">
            <div class="col-md-6 quick-view-img-container">
                <div class="img_product_container quick-view-img" data-scale="5" >                        
                    <img class="img_product"  style="background-image:url('<?php echo $image_src; ?>')">
                </div>            
            </div>
            <div class="col-md-6">
                <p class="description"><?php echo nl2br($row['description']); ?></p>
                
                <p class="price">£<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p>
                <br><br>
                <p class="property">SKU : # <?php echo $row['SKU']; ?></p>
                <?php 
                    if(isset($_SESSION['boxxcolour'])) { ?>
                        <a href="/views/buildyourbespokeboxx.php">
                            <p class="mb-0 btn-block btn btn-pink">VIEW YOUR BOXX</p>
                        </a>
                        <?php 
                    } else 
                    { 
                        ?>
                        <a href="/views/buildyourbespokeboxx.php">
                            <p class="mb-0 btn-block btn btn-pink">BUILD YOUR BOXX</p>
                        </a>
                        <?php 
                    } 
                ?>
                
            </div>
        </div>
    </div>
</div>
<?php include_once $root . "/views/footer.php"; ?>