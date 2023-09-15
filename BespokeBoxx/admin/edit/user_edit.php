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
            <h1>Edit User</h1>
            </div>
            <div class="login" >
            <form   method="post" id="UpdateUser" enctype="multipart/form-data">
            <input id="userId" name="userId" type="hidden" value="<?php echo $fetcheduser['id']; ?>">       
                <select id="urole" name="urole" style="width:310px; margin-bottom:20px;" class="form-control" data-role="select-dropdown" data-profile="minimal">
                    <?php foreach ($fetchedroles as $row) {
                        echo '<option value="' . FormatInput($row['role']) . '">'
                            . FormatInput($row['role']) . '</option>';
                    } ?>
                </select>
            <input type="text" id="firstname" name="ufirstname" value="<?php echo $fetcheduser['first_name']; ?>"  required>
            <input type="text" id="lastname" name="ulastname" value="<?php echo $fetcheduser['last_name']; ?>"  required>
            <input type="email" id="email" name="uemail" value="<?php echo $fetcheduser['email']; ?>"  required>
            <input type="text" id="phone_number" name="uphone_number" value="<?php echo $fetcheduser['phone_number']; ?>"  required>
             <input type="submit" onclick="return UpdateUser()" value="Save">
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