<?php
session_start();
if (!isset($_SESSION['boxxcolour']) && !isset($_SESSION['boxxsize']) && !isset($_SESSION['boxxfilling']) && !isset($_SESSION['boxxproducts']))
    { 
        header("Location: /views/buildyourbespokeboxx.php");
    }
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

include_once $root . "/views/header.php";

?>
<?php


foreach($_SESSION['boxxcolour'] as $key=>$value) {   ?>
<script>
    $(document).ready(function () {
        var $radios = $('input:radio[name=boxxColourRadio]');
        $radios.filter('[id="' + <?php echo $key; ?> +'"]').prop('checked', true);

    });
</script>
<?php } 
foreach($_SESSION['boxxsize'] as $key=>$value) {   ?>
<script>
    $(document).ready(function () {
        var $radios = $('input:radio[name=boxxSizeRadio]');
        $radios.filter('[id="' + <?php echo $key; ?> +'"]').prop('checked', true);

    });
</script>
<?php } 
foreach($_SESSION['boxxfilling'] as $key=>$value) {   ?>
<script>
    $(document).ready(function () {
        var $radios = $('input:checkbox[name=boxxFillingCheckbox]');
        $radios.filter('[id="' + <?php echo $key; ?> +'"]').prop('checked', true);
    });
</script>
<?php } ?>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if(isset($_SESSION['boxxcolour'])) { ?>
                        <div class="site-section-heading">
                            View Your Boxx
                        </div>
                        <?php 
                    } else 
                    { 
                        ?>
                        <div class="site-section-heading">
                            Build Your Boxx
                        </div>
                        <?php 
                    } 
                ?>
                <ul id="progress-bar" class="progressbar">
                    <li class="active" id="step1" onclick='return showColour();'>Colour</li>
                    <li class="active" id="step2" <?php if (isset($_SESSION['boxxcolour'])) { ?> onclick='return showSize();'<?php } ?>>Size</li>
                    <li class="active" id="step3" <?php if (isset($_SESSION["boxxsize"])) { ?> onclick='return showFilling();' <?php } ?>>Filling</li>
                    <li class="active" id="step4" <?php if (isset($_SESSION["boxxfilling"])) { ?> onclick='return showProducts();'<?php } ?>>Products</li>
                </ul>
                <div class="row pt-4">
                    <?php 
                        if (isset($_SESSION['boxxcolour'])) {
                            if(!isset($_SESSION['boxxEditId'])){ ?>
                                <Button class="btnn-left-top showSelection " onclick="return ClearSelection('Y');">Clear</Button>
                                <?php 
                            } else if ( isset($_SESSION['boxxEditId'])){ ?>
                                <Button class="btnn-left-top showSelection " onclick="return ClearSelection('<?php echo $_SESSION['boxxEditId'];?>');">Clear</Button>
                                <?php 
                            } ?>
                            <?php if(count($_SESSION['boxxproducts'])> 0 && !isset($_SESSION['boxxEditId'])){ ?>
                                    <button onclick="return AddBoxxToCart('<?php echo md5(uniqid('hamper'));?>');" class="btnn-right-top btn btn-pink">Add To Cart</button>
                                <?php } else if (count($_SESSION['boxxproducts'])> 0 && isset($_SESSION['boxxEditId'])){ ?>
                                    <button onclick="return AddBoxxToCart('<?php echo $_SESSION['boxxEditId'];?>');" class="btnn-right-top btn btn-pink">Save To Cart</button>
                                <?php } ?>
                            <div class="col center">
                                <p class="property">
                                    <?php 
                                    foreach($_SESSION['boxxcolour'] as $id=>$quantity) {
                                        $fetchHampers = $db->query('SELECT id, name,image FROM products where id=?', $id)->fetchArray();
                                        $image_src = "/uploadedimgs/" . $fetchHampers["image"];
                                        echo "<img class='basketImg' src='".$image_src."'>"; 
                                    } 
                                    if(isset($_SESSION['boxxcolour'])){ ?>
                                        <Button class='link-button ' onclick='return showColour();' >Edit</Button><br>
                                        <?php
                                    } ?>
                                </p>
                                <p class="property">
                                    <?php 
                                    foreach($_SESSION['boxxsize'] as $id=>$quantity) {
                                        $fetchHampers = $db->query('SELECT id, name,price,image FROM products where id=?', $id)->fetchArray(); 
                                        $getprops = $db->query('SELECT property_value FROM product_properties where product_id = ? AND property_name = ?', $id, 'Size')->fetchArray();
                                        echo $fetchHampers["name"]."<br>".$getprops['property_value']; 
                                    } 
                                        if( isset($_SESSION['boxxsize']))
                                        {  ?>
                                        <Button onclick='return showSize();' class='link-button'>Edit</Button>
                                        <?php
                                    }  ?>
                                </p>
                                <p class="property "> 
                                    <?php
                                    foreach($_SESSION['boxxfilling'] as $id=>$quantity) {
                                        $fetchHampers = $db->query('SELECT image FROM products where id=?', $id)->fetchArray();
                                        $image_src = "/uploadedimgs/" . $fetchHampers["image"];
                                        echo "<img class='basketImg' src='".$image_src."'>";  
                                
                                    } 
                                        if(isset($_SESSION['boxxfilling']) ){ ?>
                                        <Button class='link-button' onclick='return showFilling();'>Edit</Button>
                                        <?php
                                    }?>
                                </p>
                            </div>
                            <div class="col center">
                                <?php 
                                    if (isset($_SESSION['boxxsize'])){
                                        echo "<h4>£".get_bespokehamper_total($db)." incl VAT</h4>";
                                    }
                                ?>
                                <div class="circle_percent" data-percent="<?php echo $_SESSION['boxxCapacity'];?>">
                                    <div class="circle_inner">
                                        <div class="round_per">
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    if(isset($_SESSION['boxxfilling']) ){ ?>
                                        <Button class='btn-block showSelection ' onclick='return showProducts();'>Choose Products</Button>
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col center">
                                <?php if (isset($_SESSION['boxxproducts'])){?>
                                    <div class="popover-markup">
                                        <button class="showSelection" data-toggle="popover" data-placement="top" href="#">View Selection</button>
                                        <div class="content hide">
                                            <div class='table-responsive'>
                                                <table class='table table-borderless '>
                                                    <tbody>
                                                        <?php 
                                                        foreach($_SESSION['boxxproducts'] as $id=>$quantity) {
                                                            $fetchHampers = $db->query('SELECT name, price FROM products where id=?', $id)->fetchArray(); ?>
                                                        <tr>
                                                            <td><?php echo $fetchHampers["name"]; ?></td>
                                                            <td>X <?php echo $quantity; ?></td>
                                                            <td>£<?php echo $fetchHampers["price"]*$quantity; ?></td>
                                                            <td><button class="showSelection" onclick="RemoveFromCart(<?php echo $id; ?>,'Product')"><span class="icon-close"></button></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <br>
                                
                            </div>
                            <?php 
                        } 
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <div id="hamperProducts" class="panels" >
                    <button class="accordion">Choose your Products</button>
                    <div class="row">
                        <div class="col-md-2">
                            <a href="/views/byb_beauty.php">
                                <div class="p-2 border-teal mb-2">
                                    <p class="mb-0">Beauty & Care</p>
                                </div>
                            </a>
                            <a href="/views/byb_food.php">
                                <div class="p-2 border-teal mb-2">
                                    <p class="mb-0">Food & Drink</p>
                                </div>
                            </a>
                            <a href="/views/byb_home.php">
                                <div class="p-2 border-teal mb-2">
                                    <p class="mb-0">Home & Leisure</p>
                                </div>
                            </a>
                           

                            <a href="/views/byb_little.php">
                                <div class="p-2 border-teal mb-2">
                                    <p class="mb-0">Little Ones</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-10">
                            <?php 
                                $beauty_product_category = $db->query('SELECT id,name,price,SKU,image,quantity FROM products where is_deleted = ? AND status = ? AND quantity > 0 ORDER BY visibility_order asc', 0,1)->fetchAll();
                                $GetCategory = $db->query('SELECT id,name FROM product_category where id = ? ', 5)->fetchArray();
                            ?>
                            <span class="site-section-heading"><?php echo $GetCategory["name"]; ?></span>
                            <div class="div-inline-list">
                                <?php
                                    foreach($beauty_product_category as $row) {
                                        $pc = $db->query('SELECT product_id FROM products_to_category where category_id = ? AND product_id = ?',$GetCategory['id'], $row['id'])->fetchArray();
                                        if ($row['id'] == $pc["product_id"]){
                                            $image = $row['image'];
                                            $image_src = "/uploadedimgs/" . $image; ?>
                                            <div class="product-container hamperProductsCard">
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
                                                <?php
                                                    if(isset($_SESSION['boxxproducts'][$row["id"]])){
                                                        ?>
                                                        <Button class="btn btnn-left" onclick="RemoveFromCart(<?php echo $row['id']; ?>,'Product')""><span class="icon-minus"></Button>

                                                        <a class="counter-right icons-btn d-inline-block bag">
                                                            <span class="number">
                                                            <?php    
                                                                foreach($_SESSION['boxxproducts'] as $key=>$value) {
                                                                    if($key == $row['id'] ){
                                                                        echo $value;
                                                                    } 
                                                                }
                                                                ?>
                                                            </span>
                                                        </a>
                                                        <?php
                                                    }
                                                ?>
                                                <div class="img_product_container" data-scale="5"> 
                                                    <img class="img_product" src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">                       
                                                </div> 
                                                <p class="name"><?php echo $row['name']; ?></p>
                                                <p class="price">
                                                    £<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p>
                                                <?php 
                                                    if (isset($_SESSION['itemsLeft'][$row['id']])) {
                                                        foreach($_SESSION['itemsLeft'] as $i=>$q) {
                                                            if($i == $row['id']){
                                                                if($row['quantity'] - $q > 0){ ?>
                                                                    <Button class=" btn btnn-right" onclick="AddToCart(<?php echo $row['id']; ?>, 'products')"><span class="icon-plus"></Button>
                                                                <?php } 
                                                            }
                                                        }
                                                        
                                                    } else { ?>
                                                            <Button class=" btn btnn-right" onclick="AddToCart(<?php echo $row['id']; ?>, 'products')"><span class="icon-plus"></Button>
                                                        <?php 
                                                    } 
                                                ?>
                                                    <button class=" btn showSelection" onclick="return ShowQuickViewItem('<?php echo $row['id']; ?>');">Quick View</button>

                                            </div>
                                            <?php  
                                        }                                                                                         
                                    } 
                                ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include_once $root . "/views/footer.php"; ?>