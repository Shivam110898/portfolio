
<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

if (isset($_POST["query"]) && isset($_POST["category_id"])) {
    $sortBy = $_POST["query"];
    $category_id = $_POST["category_id"];

    if ($sortBy == "new"){
        $fetchedProducts = $db->query('SELECT id,name,SKU,price,quantity,image FROM products WHERE is_deleted=? and status = ? and quantity > 0  ORDER BY created_at desc', 0,1)->fetchAll();
        foreach($fetchedProducts as $row) {
            $pc = $db->query('SELECT product_id FROM products_to_category where category_id = ? AND product_id = ?',$category_id, $row['id'])->fetchArray();
            if ($row['id'] == $pc["product_id"]){
                $image = $row['image'];
                $image_src = "/uploadedimgs/" . $image; ?>
                <div class="card">    
                    <div class="img_product_container" data-scale="4"> 
                        <img class="img_product" src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">                       
                    </div> 
                    <p class="name"><?php echo $row['name']; ?></p>
                    <p class="price">£<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p> 
                    <button class="btn-block showSelection" onclick="window.location.href='/views/quickview.php?productid=<?php echo $row['id']; ?>'">Quick View</button>
                </div>
                <?php 
            }
        }
    } else if($sortBy == "low"){
        $fetchedProducts = $db->query('SELECT id,name,SKU,price,quantity,image FROM products where  is_deleted=? and status = ? and quantity > 0 ORDER BY `price`+0 asc', 0,1)->fetchAll();
        foreach($fetchedProducts as $row) {
            $pc = $db->query('SELECT product_id FROM products_to_category where category_id = ? AND product_id = ?',$category_id, $row['id'])->fetchArray();
            if ($row['id'] == $pc["product_id"]){
                $image = $row['image'];
                $image_src = "/uploadedimgs/" . $image; ?>
                <div class="card">    
                    <div class="img_product_container" data-scale="4"> 
                        <img class="img_product" src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">                       
                    </div>
                    <p class="name"><?php echo $row['name']; ?></p>
                    <p class="price">£<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p> 
                    <button class="btn-block showSelection" onclick="window.location.href='/views/quickview.php?productid=<?php echo $row['id']; ?>'">Quick View</button>
                </div>
                <?php 
            }
        }
    }else if($sortBy == "high"){
        $fetchedProducts = $db->query('SELECT id,name,SKU,price,quantity,image FROM products where  is_deleted=? and status = ? and quantity > 0 ORDER BY `price`+0 desc', 0,1)->fetchAll();
        foreach($fetchedProducts as $row) {
            $pc = $db->query('SELECT product_id FROM products_to_category where category_id = ? AND product_id = ?',$category_id, $row['id'])->fetchArray();
            if ($row['id'] == $pc["product_id"]){
                $image = $row['image'];
                $image_src = "/uploadedimgs/" . $image; ?>
                <div class="card">    
                    <div class="img_product_container" data-scale="4"> 
                        <img class="img_product" src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">                       
                    </div>
                    <p class="name"><?php echo $row['name']; ?></p>
                    <p class="price">£<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p> 
                    <button class="btn-block showSelection" onclick="window.location.href='/views/quickview.php?productid=<?php echo $row['id']; ?>'">Quick View</button>
                </div>
                <?php 
            }
        }
    }   else if($sortBy == "old"){
        $fetchedProducts = $db->query('SELECT id,name,SKU,price,quantity,image FROM products WHERE is_deleted=? and status = ? and quantity > 0  ORDER BY visibility_order asc', 0,1)->fetchAll();
        foreach($fetchedProducts as $row) {
            $pc = $db->query('SELECT product_id FROM products_to_category where category_id = ? AND product_id = ?',$category_id, $row['id'])->fetchArray();
            if ($row['id'] == $pc["product_id"]){
                $image = $row['image'];
                $image_src = "/uploadedimgs/" . $image; ?>
                <div class="card">    
                    <div class="img_product_container" data-scale="4"> 
                        <img class="img_product" src="<?php echo $image_src; ?>" alt="<?php echo $row["name"]; ?>">                       
                    </div>
                    <p class="name"><?php echo $row['name']; ?></p>
                    <p class="price">£<?php echo number_format((float)$row['price'], 2, '.', ''); ?></p> 
                    <button class="btn-block showSelection" onclick="window.location.href='/views/quickview.php?productid=<?php echo $row['id']; ?>'">Quick View</button>
                </div>
                <?php 
            }
        }
    }         
    
} 
?>

<script src="/js/image_zoomer.js"></script>
