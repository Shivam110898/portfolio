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
            <h1>Add User</h1>
            </div>
            <div class="login" >
            <form method="post" id="CreateUser" enctype="multipart/form-data">
            <?php
                $cats = $db->query('SELECT * FROM user_type where is_deleted = ? and status = ? order by role asc','0','1')->fetchAll();
           
            if (count($cats) > 0) {
            ?>
                <select id="role" name="role"  class="form-control" data-role="select-dropdown" data-profile="minimal">
                    <?php foreach ($cats as $row) {
                        echo '<option value="' . FormatInput($row['role']) . '">'
                            . FormatInput($row['role']) . '</option>';
                    } ?>
                </select>
            <?php } ?>
            <input type="text" id="firstname" name="firstname" placeholder="Enter first name" required>
            <input type="text" id="lastname" name="lastname" placeholder="Enter last name" required>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
            <input type="text" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
            <input type="password" id="comfirmpassword" name="confirmpassword" placeholder="Confirm password" required>
            <input type="submit" onclick="return CreateUser()" value="Save">
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