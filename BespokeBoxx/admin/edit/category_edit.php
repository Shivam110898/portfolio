<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.categories.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";

?>
<div class="container-fluid">
    <div class="maincontent">
    <div class="row ">

    <div class="adminForm">
            <div class="page-header mb-4">
            <h1>Edit Category</h1>
            </div>
            <div class="login" >
            <form  method="post" id="UpdateCategory" enctype="multipart/form-data">
            <input id="catId" name="catId" type="hidden" value="<?php echo $fetchedcategory['id']; ?>">       
            <input type="text" id="uname" name="uname" value="<?php echo $fetchedcategory['name']; ?>" required>
            <input type="text" id="udescription" name="udescription" value="<?php echo $fetchedcategory['description']; ?>" required>
                <input type="submit" onclick="return UpdateCategory()" value="Save">
        </form>      
        </div>
            <br />
            </div>

        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>