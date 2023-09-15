<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);


if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "SELECT * FROM order_details where  order_no LIKE '%" . $search . "%' OR  user_id LIKE '%" . $search . "%' ";
} else {
    $query = "SELECT * FROM order_details ORDER BY created_at desc";
}
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table table-borderless table-hover'>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Recipient</th>
                    <th>Gift Message</th>
                    <th>Items</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                    <td><?php echo $row['order_no']; ?></td>
                    <td><?php echo $row['recipient_name']; ?></td>
                    <td><?php echo $row['gift_message']; ?></td>
                    <td><?php 
                    $getItems = "SELECT * FROM order_items where order_id = '".$row['id']."'";
                    $getItemsresult = mysqli_query($connect, $getItems);
                    if (mysqli_num_rows($getItemsresult) > 0) {
                        while ($getItemsRow = mysqli_fetch_array($getItemsresult)) {
                            $getProducts = "SELECT * FROM products where id = '".$getItemsRow['product_id']."'";
                            $getProductsresult = mysqli_query($connect, $getProducts);
                            if (mysqli_num_rows($getProductsresult) > 0) {
                                while ($getProductsRow = mysqli_fetch_array($getProductsresult)) {
                                    echo $getProductsRow["name"]."<br>";
                                }
                            }
                        }
                    }
                    ?></td>
                    <td><?php echo date("d/m/Y H:i:s", strtotime($row['created_at'])); ?></td>
                    <td>
                        <button onclick="ViewOrderDetails('<?php echo $row['id'];  ?>')" type="button" class='btn bg-dark text-white btn-md'>
                            <span class='fa fa-eye'></span>
                        </button>
                        <button onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.orders.php');" type='button' class='btn btn-danger btn-md'>
                             <span class='fa fa-trash'></span>
                        </button>
                            <?php
                            if ($row['status'] == 0) {
                            ?>
                                <button onclick="ToggleStatus('dispatched','<?php echo $row['id'];  ?>','/logics/logic.orders.php');" class="btn btn-warning ">Pending</button>
                            <?php } else { ?>
                                <button onclick="ToggleStatus('pending','<?php echo $row['id'];  ?>','/logics/logic.orders.php');" class="btn btn-success ">Dispatched</button>
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