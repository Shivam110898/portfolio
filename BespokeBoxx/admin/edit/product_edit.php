<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.products.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";

?>

<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">

            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Edit Product</h1>
                </div>
                <div class="row">
                    
                    <div class="col-md-6">
                        <form method="post" id="UpdateProduct" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?php echo $fetchedproduct['id']; ?>">
                            
                            <?php
                                foreach ($fetchedcats as $row) { ?>
                                    <span for="category"><?php echo $row['name'];?></span>
                                    <input type="checkbox" name="category[]" id="<?php echo $row['name'];?>" value="<?php echo $row['id'];?>" 
                                    <?php 
                                    foreach($assignedCategories as $category){
                                        if ( $category['category_id'] == $row['id'] ): ?> checked
                                        <?php endif; 
                                    } ?>
                                   " >
                                <?php }
                            ?>
                            <input type="text" placeholder="Name" name="uname" value="<?php echo $fetchedproduct['name']; ?>" required>
                            <input type="text" placeholder="Url/Wholesaler" name="uurl" value="<?php echo $fetchedproduct['url']; ?>" >
                            <textarea type="text" placeholder="Description" name="udesc" ><?php echo $fetchedproduct['description']; ?></textarea>
                            <input type="text" placeholder="Cost" name="ucost" value="<?php echo $fetchedproduct['cost']; ?>" >
                            <input type="text" placeholder="Price" name="uprice" value="<?php echo $fetchedproduct['price']; ?>" >
                            <input type="text" placeholder="Quantity" name="uquantity" value="<?php echo $fetchedproduct['quantity'] ?>" >
                            <table class="table table-borderless" id="dynamic_field">

                                <?php foreach ($fetchedproductprops as $prop)  { ?>
                                        <tr id="row<?php echo $prop['property_value'];?>">
                                            <td><input type="text" name="pname[]" placeholder="Enter property name"
                                                    value="<?php echo $prop['property_name']; ?>" /></td>
                                            <td><input type="text" name="pvalue[]" placeholder="Enter property value"
                                                    value="<?php echo $prop['property_value']; ?>" /></td>
                                            <td><button type="button" name="remove" id="<?php echo $prop['property_value'];?>" class="btn btn-danger btn_remove">Remove</button></td>
                                        </tr>

                                <?php }?>
                                <td><button type="button" name="add" id="add" class="btn btn-primary">Add</button></td>

                            </table>
                            
                            <input type="submit" name="update" onclick="return UpdateProduct()" value="Update">
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="post" id="UpdateProductImage" enctype="multipart/form-data">
                            <input  name="prodId" type="hidden" value="<?php echo $fetchedproduct['id']; ?>">
                            <input name="userImage" id="uuserImage" type="file" />
                            
                            <input type="submit" name="update" onclick="return UpdateProductImage()" value="Save Image">
                        </form>
                    </div>
                </div>
                <br />
            </div>

        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>