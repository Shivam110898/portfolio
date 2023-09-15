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
                <div class="site-section-heading">PICK UP TO 2 FREE BESPOKEBOXX FILLINGS</div>
            </div>
            <div class="col-md-12">
                 <div class="div-inline-list">
                        <?php   
                            $product_category = $db->query('SELECT * FROM products_to_category where category_id = ?', 10)->fetchAll();
                            foreach($product_category as $product) {

                                $row = $db->query('SELECT * FROM products where is_deleted = ? and id = ? and status = ? ORDER BY created_at asc', '0',$product['product_id'],'1')->fetchArray();
                        
                                    $image = $row['image'];
                                    $image_src = "/uploadedimgs/" . $image;
                                    ?>
                                    <!-- create the product container the user sees -->
                                    <div class="product-container fillingsCard">
                                        <img src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">
                                    </div>

                            <?php 
                            }?>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $root . "/views/footer.php"; ?>