<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.products.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<script>
    $(document).ready(function () {
        $('.dynamic_field_hampers').hide();
        $('input[name="category[]"]').on("click", function () {
                var optionSelected = $(":checked", this);
            var valueSelected = this.id;
            if  (valueSelected == "Hampers" || valueSelected == "Filling"  ||valueSelected == "HOTM"||valueSelected == "Hamper Colour" || valueSelected=="Inspirations" ){
                $('.dynamic_field_hampers').hide();          
            } else {
                $('.dynamic_field_hampers').show();
            }
        });
    });
</script>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row shadow">
            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Add Product</h1>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <form method="post" id="CreateProduct" enctype="multipart/form-data">
                        <?php
                        $cats = $db->query('SELECT * FROM product_category where is_deleted = ? and status = ? order by name asc','0','1')->fetchAll();
                        if (count($cats) > 0) {
                            foreach ($cats as $row) { ?>
                                <span for="category"><?php echo $row['name'];?></span>
                                <input type="checkbox" name="category[]" id="<?php echo $row['name'];?>" value="<?php echo $row['id'];?>">
                            <?php }
                        } ?>
                        <input type="text" id="name" name="name" placeholder="Enter product name" required>
                        <input type="text" id="url" name="url" placeholder="Enter product URL" >
                        <textarea type="text" placeholder="Enter Description" name="desc" ><?php echo $fetchedproduct['description']; ?></textarea>
                        <input type="text" id="cost" name="cost" placeholder="Enter product cost" >
                        <input type="text" id="price" name="price" placeholder="Enter product price" >
                        <input type="text" id="quantity" name="quantity" placeholder="Enter product quantity" >
                        <input name="userImage" id="userImage" type="file"  />

                        <table class="table table-borderless" id="dynamic_field">
                            <td><button type="button" name="add" id="add" class="btn btn-primary">Add Properties</button></td> 
                            <?php 
                            $HamperSizes = array("FillsSmall","FillsMedium","FillsLarge");
                            foreach ($HamperSizes as $size)  {
                                    ?>
                                    <tr class="dynamic_field_hampers">
                                        <td><input type="text" name="pname[]"  value="<?php echo $size; ?>" /></td>
                                        <td><input type="text" name="pvalue[]"  placeholder="Enter value" /></td>
                                    </tr>
                                <?php  
                            }?>
                        </table>


                         
                        <input type="submit" onclick="return CreateProduct()" value="Save">
                    </form>
                    </div>
                    </div>

            </div>
        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>