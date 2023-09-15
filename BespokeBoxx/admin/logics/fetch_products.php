<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);

$query;

if (isset($_POST["query"]) && isset($_POST["category_id"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $id = mysqli_real_escape_string($connect, $_POST["category_id"]);
    $query = "SELECT * FROM products where is_deleted = 0 AND name LIKE '%" . $search . "%' AND  id IN (SELECT product_id FROM products_to_category WHERE category_id='".$id."' ) ORDER BY visibility_order asc";
} 
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table table-borderless table-hover'>
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Visibility Order</th>
                    <th>Category</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Profit/Unit</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {

                    $sql = "SELECT * FROM products_to_category where product_id = " . $row['id'] . "";
                    $result1 = mysqli_query($connect, $sql);
                    $image = $row['image'];
                    $image_src = "/uploadedimgs/" . $image;

                ?>
                    <tr>

                        <td><img src="<?php echo $image_src; ?>" width=80 height=90 /></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                            <input class="form-control" min=0 onchange="return ChangeVisOrder('<?php echo $row['id']; ?>',this.value)" type="number" value="<?php echo $row['visibility_order']; ?>" ></td>

                        <td>
                            <?php
                                while ($products_to_category = mysqli_fetch_array($result1)) {
                                    $sql1 = "SELECT * FROM product_category where id = " . $products_to_category['category_id'] . "";
                                    $result2 = mysqli_query($connect, $sql1);
                                    $catrow = mysqli_fetch_array($result2);
                                    echo $catrow['name']."<br>";
                                } 
                            ?>
                        </td>
                        <td>£<?php echo $row['cost']; ?></td>
                        <td>£<?php echo $row['price']; ?></td>
                        <td>£<?php echo number_format($row['price'] - $row['cost'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <button onclick="EditProduct('<?php echo $row['id'];  ?>','/logics/logic.products.php');" type='button' class='btn btn-dark btn-md'>
                                <span class='fa fa-pencil'></span>
                            </button>
                            <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.products.php');" type='button' class='btn btn-danger btn-md'>
                                <span class='fa fa-trash'></span>
                            </button>
                            <?php
                            if ($row['status'] == 1) {
                            ?>
                                <button onclick="ToggleStatus('deactivate','<?php echo $row['id'];  ?>','/logics/logic.products.php');" class="btn btn-success ">IN STOCK</button>
                            <?php } else { ?>
                                <button onclick="ToggleStatus('activate','<?php echo $row['id'];  ?>','/logics/logic.products.php');" class="btn btn-warning ">NOT IN STOCK</button>
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