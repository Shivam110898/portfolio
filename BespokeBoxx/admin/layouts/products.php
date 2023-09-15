<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];




include_once $root . "/logics/logic.products.php";
 // Check if the user is logged in, if not then redirect to login page
if(isset($_COOKIE['REMEMBER_ME'])) {
    // Decrypt cookie variable value
    $userid=decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser=$db->query('select * from admin_user where email = ?', $userid)->fetchAll();

    $count=count($getuser);

    if($count > 0) {
        $_SESSION['USER']=$userid;
    }
} else if(!isset($_COOKIE['REMEMBER_ME']) && !isset($_SESSION['USER'])) {
    header("location: /layouts/logout.php");
}
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<script type="text/javascript">
    $(document).ready(function () {
        
    });
</script>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-header">
                    <h1>Products</h1>
                </div>

            </div>
            <div class="col-sm-12">
                <div class="tab">
                    <button onclick="window.location.href='/create/product_create.php'" class="tablinks " >Add Product</button>
                    <?php  
                        $productCategories = $db->query('SELECT * FROM product_category where is_deleted = ? ORDER BY name','0')->fetchAll();
                        foreach($productCategories as $cat){?>
                            <button class="tablinks" id="defaultOpen" onclick="openCity(event, '<?php echo $cat['id'];?>')"><?php echo $cat["name"];?></button>
                            <?php 
                        } 
                    ?>
                </div>
                <?php  
                    foreach($productCategories as $cat){ ?>
                        <div id="<?php echo $cat['id'];?>" class="tabcontent">
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    var searchdiv = 'search_text<?php echo $cat['id'];?>';
                                    $('#'+searchdiv).keyup(function () {
                                        var search = $(this).val();
                                        if (search != '') {
                                            LoadProducts(search,'<?php echo $cat['id'];?>','div<?php echo $cat['id'];?>');
                                        } else {
                                            LoadProducts('','<?php echo $cat['id'];?>','div<?php echo $cat['id'];?>');
                                        }
                                    });
                                    LoadProducts('','<?php echo $cat['id'];?>','div<?php echo $cat['id'];?>');
                                });
                            </script>
                            <input type="text" name="search_text" id="search_text<?php echo $cat['id'];?>" class="search_text" placeholder="Search" class="form-control" />
                            <div id="div<?php echo $cat['id'];?>">
                            </div>

                        </div>
                        <?php 
                    } 
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once $root . "/layouts/footer.php";
?>