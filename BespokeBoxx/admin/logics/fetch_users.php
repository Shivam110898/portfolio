<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);


if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query ="SELECT * FROM admin_user where user_type_id != '5' AND  user_type_id != '6' AND is_deleted = 0 AND email LIKE '%" . $search . "%'
    OR  first_name LIKE '%" . $search . "%'
    OR  last_name LIKE '%" . $search . "%'";
} else {
    $query = "SELECT * FROM admin_user where user_type_id != '5' AND user_type_id != '6' AND is_deleted = 0 ORDER BY last_Login desc";
}
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table table-borderless table-hover'>
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Last Login</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {

                    $sql = "SELECT * FROM user_type where id = " . $row['user_type_id'] . "";
                    $result1 = mysqli_query($connect, $sql);
                    $catrow = mysqli_fetch_array($result1);

                ?>
                    <tr>

                        <td><?php echo $catrow['role']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($row['last_login'])); ?></td>
                        <td>
                        <button onclick="EditUser('<?php echo $row['id'];  ?>')" type="button" class='btn bg-dark text-white btn-md'>
                                <span class='fa fa-pencil'></span>
                            </button> 
                            <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.users.php');" type='button' class='btn btn-danger btn-md'>
                                <span class='fa fa-trash'></span>
                            </button>
                            <?php
                            if ($row['status'] == 1) {
                            ?>
                                <button onclick="ToggleStatus('deactivate','<?php echo $row['id'];  ?>','/logics/logic.users.php');" class="btn btn-success ">Active</button>
                            <?php } else { ?>
                                <button onclick="ToggleStatus('activate','<?php echo $row['id'];  ?>','/logics/logic.users.php');" class="btn btn-warning ">Not Active</button>
                            <?php } ?>

                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {
?>
    <p class='lead'><em>No records were found.</em></p>
<?php
}

mysqli_close($connect);
?>