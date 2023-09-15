<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);

$query = "SELECT * FROM hamper_of_the_month";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
<div class="page-header mb-4">
    <h1 class="mb-4">Hamper Of The Month</h1>
    <a href="/create/hotm_create.php" class="button" role="button">Add Hamper</a>
</div>
<div class='table-responsive'>
    <table class='table table-borderless table-hover'>
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Products</th>
                <th>Description</th>
                <th>Total</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php
                while ($row = mysqli_fetch_array($result)) {

                    $sql = "SELECT * FROM hotm_products where id_hotm = " . $row['id'] . "";
                    $result1 = mysqli_query($connect, $sql);

                    $image = $row['image'];
                    $image_src = "/uploadedimgs/" . $image;

                ?>
            <tr>

                <td><img src="<?php echo $image_src; ?>" width=80 height=90 /></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php                     while ( $hotmRow = mysqli_fetch_array($result1)) {
                        
                        $getproductsssql = "SELECT * FROM products where id = " . $hotmRow['id_product'] . "";
                        $productsresult = mysqli_query($connect, $getproductsssql);
                        
                        while ($productrow = mysqli_fetch_assoc($productsresult)) {
                            echo $productrow['name']; ?><br><?php
                        }
                                        
                    } ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>£<?php echo $row['total']; ?></td>
                <td>
                    <button onclick="EditHOTM('<?php echo $row['id'];  ?>')" type="button"
                        class='btn bg-dark text-white btn-md'>
                        <span class='fa fa-pencil'></span>
                    </button>
                    <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.hotm.php');" type='button'
                        class='btn btn-danger btn-md'>
                        <span class='fa fa-trash'></span>
                    </button>
                    <?php
                            if ($row['status'] == 1) {
                            ?>
                    <button
                        onclick="ToggleStatus('deactivate','<?php echo $row['id'];  ?>','/logics/logic.hotm.php');"
                        class="btn btn-success ">Active</button>
                    <?php } else { ?>
                    <button
                        onclick="ToggleStatus('activate','<?php echo $row['id'];  ?>','/logics/logic.hotm.php');"
                        class="btn btn-warning ">Not Active</button>
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