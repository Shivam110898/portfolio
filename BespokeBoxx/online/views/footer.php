<div class="hidden" id="cookie-banner">
  <div>
    <span>
      This site uses cookies to provide you with a great user experience. By using this site, you accept our <a
        href="/views/policies/terms_&_conditions.php">Terms of Service</a>.
    </span>
    <span id="consent-cookies">
      <Button class="showSelection">I Accept</Button>

    </span>
  </div>
</div>

<div id="quickViewItem">
  <div class="modal-content">
    <div class="modal-header">
      <span type="button" id="closeqwi" data-dismiss="modal" class="close" >&times;</span>
    </div>
    <div class="modal-body">
      <div id="detailedView">
      </div>
    </div>
  </div>
</div>
<?php 
$product_category = $db->query('SELECT product_id FROM products_to_category where category_id = ?', 11)->fetchArray(); 
$hotm = $db->query('SELECT id,name,price,SKU,image,quantity FROM products where id = ? and is_deleted=? and status = ?', $product_category["product_id"],0,1)->fetchArray();
$image_srcs = "/uploadedimgs/" . $hotm["image"]; 
?>
<div id="botmModal">
  <div class="modal-content">
    <div class="modal-header">
    <div class="title-section">
        <h2 class="text-uppercase"><span class="d-block">BespokeBoxx of the Month</h2>
      </div>      <span type="button" id="closebotm" data-dismiss="modal" class="close" >&times;</span>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-6">
            <div class="img_product_container quick-view-img quickViewImg" data-scale="3" >                        
              <img class="img_product"   src="<?php echo $image_srcs; ?>">
            </div>            
        </div>
        <div class="col-md-6 ">
          <h2 class="site-section-heading"><?php echo $hotm["name"]; ?></h2>
          <?php
          $product_category = $db->query('SELECT product_id FROM products_to_category where category_id = ?', 11)->fetchArray(); 
          $hotm = $db->query('SELECT id,name,price,SKU,image,quantity FROM products where id = ? and is_deleted=? and status = ?', $product_category["product_id"],0,1)->fetchArray();
          $image_src = "/uploadedimgs/" . $hotm["image"]; 
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
        
      </div>
    </div>
  </div>
</div>


<div id="alertModal" class="modal fade">

  <div class="alert-modal-content">

    <div class="modal-body">
      <div class="row">
        <p class="name"></p>
      </div>
    </div>
    <div class="modal-footer">
      <Button class="btn btn-pink btn-block" data-dismiss="modal" onClick="window.location.reload();">OK</Button>
    </div>
  </div>
</div>

<footer class="site-footer ">
  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <div class="row">
          <div class="col-md-12">
            <h3 class="footer-heading mb-4">Quick Links</h3>
          </div>
          <div class="col-md-12">
            <ul class="list-unstyled">
              <li class="startbtn">
                <?php if(isset($_SESSION['boxxcolour'])) {
                                            ?>
                <a href="/views/buildyourbespokeboxx.php">View Your Boxx</a>
                <?php } else { ?>
                <a href="/views/buildyourbespokeboxx.php ">Build Your Boxx</a>
                <?php } ?>
              </li>
              <li><a href="/views/productCategories/theboxx.php">The Boxx</a></li>
              <li><a href="/views/productCategories/beauty.php">Beauty & Care</a></li>
              <li><a href="/views/productCategories/food_drink.php">Food & Drink</a></li>
              <li><a href="/views/productCategories/home_gifts.php">Home & Leisure</a></li>
              <li><a href="/views/productCategories/little_ones.php">Little Ones</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="row">
          <div class="col-md-12">
            <h3 class="footer-heading mb-4">About Us</h3>
          </div>
          <div class="col-md-12">
            <ul class="list-unstyled">
            <li><a href="/views/policies/terms_&_conditions.php">Terms & Conditions</a></li>
            <li><a href="/views/policies/cookie_policy.php">Cookie</a></li>
            <li><a href="/views/policies/privacy_policy.php">Privacy</a></li>
            <li><a href="/views/policies/delivery_policy.php">Delivery & Returns</a></li>

            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="block-5 mb-5">
          <h3 class="footer-heading mb-4">Contact Info</h3>
          <ul class="list-unstyled">
            <li class="email">info@bespokeboxx.co.uk</li>
            <div class="icons">
              <a href="https://www.facebook.com/bespokeboxx/" class="icons-btn d-inline-block"><span
                  class="icon-facebook"></span></a>
              <a href="https://www.instagram.com/bespokeboxx_/?hl=en" class="icons-btn d-inline-block"><span
                  class="icon-instagram"></span></a>
              <a href="https://twitter.com/BespokeBoxx" class="icons-btn d-inline-block"><span
                  class="icon-twitter"></span></a>
            </div>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="block-5 mb-5">
          <ul class="list-unstyled">
          <img class="payment-methods" src="/images/methods.png">
            <img class="payment-methods" src="/images/powered.png">
            <img class="ssl-img" src="/images/ssl.png">

          </ul>
        </div>

      </div>
    </div>

    <div class="row text-center">
      <div class="col-md-12 ">
        <p>
         | Copyright &copy;2021 | All rights reserved | 
        </p>
        <p>
          Developed by BespokeBoxx
        </p>
      </div>

    </div>
  </div>
</footer>
</div>

<script src="/js/jquery-ui.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/jquery.magnific-popup.min.js"></script>
<script src="/js/aos.js"></script>
<script src="/js/main.js"></script>
<script src="/js/image_zoomer.js"></script>
 
</body>

</html>