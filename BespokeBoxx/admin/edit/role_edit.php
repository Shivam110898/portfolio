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
            <h1>Edit Role</h1>
            </div>
            <div class="login" >
            <form  method="post" id="UpdateRole" enctype="multipart/form-data">
            <input id="roleId" name="roleId" type="hidden" value="<?php echo $fetchedrole['id']; ?>">       
            <input type="text" id="urole" name="urole" value="<?php echo $fetchedrole['role']; ?>" required>
                <input type="submit" onclick="return UpdateRole()" value="Save">
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