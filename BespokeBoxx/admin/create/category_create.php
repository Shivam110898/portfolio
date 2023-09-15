<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.users.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="adminForm">
                <div class="page-header mb-4">
                    <h1>Add Category</h1>
                </div>
                <div class="login">
                    <form method="post" id="CreateCategory" enctype="multipart/form-data">
                        <input type="text" id="name" name="name" placeholder="Enter name" required>
                        <input type="text" id="description" name="description" placeholder="Enter description" required>
                        <input type="submit" onclick="return CreateCategory()" value="Save">
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