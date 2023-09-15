<?php
session_start();

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
<?php } ?>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($_SESSION['boxxcolour'])) { ?>
                    <div class="site-section-heading">View Your Boxx</div>
                <?php } else { ?>
                    <div class="site-section-heading">Build Your Boxx</div>
                <?php } ?>
                <ul id="progress-bar" class="progressbar">
                    <li class="active" id="step1" onclick='return showColour();'>Colour</li>
                    <li  id="step2" <?php if (isset($_SESSION['boxxcolour'])) { ?> onclick='return showSize();'
                        <?php } ?>>Size</li>
                    <li  id="step3" <?php if (isset($_SESSION["boxxsize"])) { ?> onclick='return showFilling();' <?php } ?>>
                        Filling</li>
                    <li  id="step4" <?php if (isset($_SESSION["boxxfilling"])) { ?> onclick='return showProducts();'
                        <?php } ?>>Products</li>
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
                <div id="hamperColour" class="panels" data-aos="fade-left">
                    <button class="accordion">Choose your Boxx colour</button>
                    <div class="div-inline-list">
                        <?php 
                        $product_category = $db->query('SELECT product_id FROM products_to_category where category_id = ?', 12)->fetchAll();
                        foreach($product_category as $pc) {
                            $row = $db->query('SELECT id,image FROM products where id = ? AND is_deleted = ? AND status = ? ORDER BY created_at asc',$pc['product_id'], '0','1')->fetchArray();

                            if(count($row)>0){
                                $image = $row['image'];
                                $image_src = "/uploadedimgs/" . $image; ?>
                                <div class="product-container hamperColourCard">
                                    <input id="<?php echo $row["id"]; ?>" type="radio" name="boxxColourRadio" hidden>
                                    <label for="<?php echo $row["id"]; ?>" class="clickable"><span class="checked-box">&#10004;</span></label>
                                    <img src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">
                                </div>

                            <?php } 
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once $root . "/views/footer.php"; ?>