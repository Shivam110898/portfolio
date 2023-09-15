<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);


if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "SELECT * FROM discount where is_deleted = 0 AND description LIKE '%" . $search . "%'";
} else {
    $query = "SELECT * FROM discount where is_deleted = 0 ORDER BY created_at";
}
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table table-borderless table-hover'>
            <thead>
                <tr>
                    <th>Discount Group</th>
                    <th>Description</th>
                    <th>Discount Type</th>
                    <th>Discount Value</th>
                    <th>Minimum total</th>
                    <th>Use Count</th>
                    <th>Expiry</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo $row['discount_group']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['discount_type']; ?></td>
                        <td><?php echo $row['discount_value']; ?></td>
                        <td><?php echo $row['minimum_total']; ?></td>
                        <td><?php echo $row['used']; ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($row['expiry'])); ?></td>
                        <td>
                        <button onclick="EditDiscount('<?php echo $row['id'];  ?>')" type="button" class='btn bg-dark text-white btn-md'>
                            <span class='fa fa-pencil'></span>
                        </button>
                        <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.discount.php');" type='button' class='btn btn-danger btn-md'>
                            <span class='fa fa-trash'></span>
                        </button>
                        <?php 
                            if ($row['status'] == 1) { ?>
                                <button onclick="ToggleStatus('deactivate','<?php echo $row['id'];  ?>','/logics/logic.discount.php');" class="btn btn-success ">Active</button>
                            <?php } else { ?>
                                <button onclick="ToggleStatus('activate','<?php echo $row['id'];  ?>','/logics/logic.discount.php');" class="btn btn-warning ">Not Active</button>
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