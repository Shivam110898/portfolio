<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);


if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "SELECT * FROM product_category where is_deleted = 0 AND name LIKE '%" . $search . "%' OR is_deleted = 0 AND description LIKE '%" . $search . "%' ";
} else {
    $query = "SELECT * FROM product_category where is_deleted = 0 ORDER BY name";
}
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table table-borderless table-hover'>
            <thead>
                <tr>
                    <th>Product Category</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                        <td>
                                <button onclick="EditCategory('<?php echo $row['id'];  ?>')" type="button" class='btn bg-dark text-white btn-md'>
                                    <span class='fa fa-pencil'></span>
                                </button>

                                <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.categories.php');" type='button' class='btn btn-danger btn-md'>
                                    <span class='fa fa-trash'></span>
                                </button>
                            <?php
                            if ($row['status'] == 1) {
                            ?>
                                <button onclick="ToggleStatus('deactivate','<?php echo $row['id'];  ?>','/logics/logic.categories.php');" class="btn btn-success ">Active</button>
                            <?php } else { ?>
                                <button onclick="ToggleStatus('activate','<?php echo $row['id'];  ?>','/logics/logic.categories.php');" class="btn btn-warning ">Not Active</button>
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