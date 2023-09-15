<?php 
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);

if (isset($_GET["productid"])) {
    $id = $_GET["productid"];
    $row = $db->query('SELECT id,name,image,price,quantity,SKU FROM products where id = ? ', $id)->fetchArray();
    $image = $row['image'];
    $image_src = "/uploadedimgs/" . $image;
}
?>

<div class="row">
    <div class="col-md-6 quick-view-img-container">

        <div class="img_product_container quick-view-img" data-scale="5" >  
        <?php 
            if(isset($_SESSION['boxxsize'])){
                foreach($_SESSION['boxxsize'] as $key=>$value) {
                    $id = $row["id"];
                    $product = $db->query('SELECT name FROM products where id = ?', $key)->fetchArray();
                    if ($product["name"] == "Small"){
                        $fillsHamperby = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsSmall')->fetchArray();
                            ?>
                        <a class="counter-left icons-btn d-inline-block bag">
                            <span class="fillshamperby">
                                <?php echo "Fills ".$fillsHamperby["property_value"]."%"; ?>

                            </span>
                        </a>
                        <?php
                    } else if ($product["name"] == "Medium"){
                        $fillsHamperby = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsMedium')->fetchArray();
                        ?>
                        <a class="counter-left icons-btn d-inline-block bag">
                            <span class="fillshamperby">
                                <?php echo "Fills ".$fillsHamperby["property_value"]."%"; ?>
                            </span>
                        </a>
                        <?php   
                    } else if ($product["name"] == "Large"){
                        $fillsHamperby = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsLarge')->fetchArray();
                            ?>
                            <a class="counter-left icons-btn d-inline-block bag">
                                <span class="fillshamperby">
                                    <?php echo "Fills ".$fillsHamperby["property_value"]."%"; ?>
                                </span>
                            </a>
                        <?php             
                    }
                }
            } 
        ?>
            <img class="img_product"  style="background-image:url('<?php echo $image_src; ?>')">
        </div>            
    </div>
    <div class="col-md-6">
        <p class="name"><?php echo $row['name']; ?></p>
        <p class="description"><?php echo $row['description']; ?></p>
        <?php
            $props = $db->query('SELECT property_value FROM product_properties where product_id = ? ', $item["id"])->fetchAll(); 
            foreach($props as $prop){
                ?>
                <p class="property"><?php echo $prop['property_value']; ?></p>
                <?php 
            } 
        ?>
        <p class="price">£<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p>
        <br><br>
        <p class="property">SKU : # <?php echo $row['SKU']; ?></p>
        <Button class="showSelection " onclick="AddToCart(<?php echo $row['id']; ?>, 'products')">Add to Boxx</Button>

    </div>
</div>
<script src="/js/image_zoomer.js"></script>
