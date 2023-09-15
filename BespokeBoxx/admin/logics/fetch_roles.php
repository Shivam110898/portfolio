<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);


if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query =
        "SELECT * FROM user_type where is_deleted = 0 
    AND role LIKE '%" . $search . "%' ";
} else {
    $query = "SELECT * FROM user_type where is_deleted = 0 ORDER BY role desc";
}
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table table-borderless table-hover'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Role</th>
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

                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                       
                            <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.roles.php');" type='button' class='btn btn-danger btn-md'>
                                <span class='fa fa-trash'></span>
                            </button>
                            <?php
                            if ($row['status'] == 1) {
                            ?>
                                <button onclick="ToggleStatus('deactivate','<?php echo $row['id'];  ?>','/logics/logic.roles.php');" class="btn btn-success ">Active</button>
                            <?php } else { ?>
                                <button onclick="ToggleStatus('activate','<?php echo $row['id'];  ?>','/logics/logic.roles.php');" class="btn btn-warning ">Not Active</button>
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