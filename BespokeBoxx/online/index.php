<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/helpers/Database.php";
require_once $root . "/helpers/config.php";
require_once $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);
include $root . "/logics/visitor_activity_log.php";
include $root . "/views/header.php";

?>
<div class="site-blocks-cover" data-aos="fade-top">
  <div class="container">
    <div class="row">
      <div class="col-md-6 ml-auto order-md-2 align-self-start">
        <div class="site-block-cover-content">
          <p>
            <?php if(isset($_SESSION['boxxcolour'])) {?>
              <a href="/views/buildyourbespokeboxx.php" class="btn btn-pink ">View Your Boxx</a>
              <?php } else { ?>
              <a href="/views/buildyourbespokeboxx.php" class="btn btn-pink ">Build Your Boxx</a>
              <?php } ?>
          </p>
          <h2 class="sub-title">Your BespokeBoxx</h2>
          <h1>For any occasion</h1>
        </div>
      </div>
      <div class="col-md-6 order-1 align-self-center">
        <div id="slideshow" class="slideshow">
          <div>
            <img src="/images/IMG_6500.jpg" alt="BespokeBoxx Hamper">
          </div>
          <div>
            <img src="/images/IMG_6501.jpg" alt="BespokeBoxx Hamper">
          </div>
          <div>
            <img src="/images/IMG_6502.jpg" alt="BespokeBoxx Hamper">
          </div>
          <div>
            <img src="/images/IMG_6503.jpg" alt="BespokeBoxx Hamper">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
$product_category = $db->query('SELECT product_id FROM products_to_category where category_id = ?', 11)->fetchArray(); 
$hotm = $db->query('SELECT id,name,price,SKU,image,quantity FROM products where id = ? and is_deleted=? and status = ?', $product_category["product_id"],0,1)->fetchArray();
$image_src = "/uploadedimgs/" . $hotm["image"]; 

if(count($hotm) > 0){

?>
  <div class="site-section data-aos="fade-top">
    <div class="container">
      <div class="title-section mb-5">
        <h2 class="text-uppercase"><span class="d-block">BespokeBoxx of the Month</h2>
      </div>
      <div class="row">
                
        <div class="col-md-6 ">
          <h2 class="site-section-heading"><?php echo $hotm["name"]; ?></h2>
          <?php
            $hotm_products = $db->query('SELECT property_value FROM product_properties where product_id = ? ', $hotm['id'])->fetchAll(); 
            foreach($hotm_products as $hotm_product){ ?>
              <p class="property"><?php echo $hotm_product['property_value']; ?></p>
              <?php 
            } 
          ?>
          <p class="price">£<?php echo number_format((float)$hotm['price'], 2, '.', ''); ?></p>
          <br><br>
          <p class="property">SKU : # <?php echo $hotm['SKU']; ?></p>
          <?php 
            if(($hotm['quantity'] - count($_SESSION['botmBoxx']) > 0)){ ?>
              <Button class="mb-0 btn-block btn btn-pink" onclick="return AddHOTM('<?php echo md5(uniqid('hotm')); ?>', '<?php echo $hotm['id']; ?>');">ADD TO CART</Button>
              <?php 
            } 
          ?>
        </div>
        <div class="col-md-6 col-md-6 col-sm-12 order-first order-sm-last quick-view-img-container">
          <div class="img_product_container quick-view-img quickViewImg" data-scale="3" >                        
            <img class="img_product"   style="background-image:url('<?php echo $image_src; ?>')">
          </div>            
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="site-section  data-aos="fade-top">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ">
        <div class="title-section mb-5">
          <h2 class="text-uppercase"><span class="d-block">BespokeBoxx Inspirations</h2>
        </div>
        <div class="inspirations-slider owl-carousel">
            <?php
              $beauty_product_category = $db->query('SELECT product_id FROM products_to_category where category_id = ?', 14)->fetchAll();
              foreach($beauty_product_category as $pc) {
                $row = $db->query('SELECT image FROM products where id = ? AND is_deleted = ? AND status = ? AND quantity > 0 ORDER BY created_at asc',$pc['product_id'], 0,1)->fetchArray();
                if (count($row)>0) {
                  $image = $row['image'];
                  $image_src = "/uploadedimgs/" . $image; ?>
                  <div class="inspo-card">    
                      <div class="img_product_container " data-scale="3"> 
                          <img class="img_product" alt="BespokeBoxx Inspiration" src="<?php echo $image_src; ?>" >                       
                      </div> 
                  </div>
                  <?php 
                }
              }
            ?>
        </div> 
      </div> 
    </div>
    <script>
        $(".inspirations-slider").owlCarousel({
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000, //2000ms = 2s;
          autoplayHoverPause: true,
          responsiveClass: true,
          autoHeight: true,
          smartSpeed: 800,
          nav: true,
          responsive: {
            0: {
              items: 1
            },

            600: {
              items: 2
            },

            1200: {
              items: 3
            },

            1366: {
              items: 3
            }
          }
        });
    </script>
  </div>
</div>
<?php
include $root . "/views/footer.php";
?>