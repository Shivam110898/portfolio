<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
$connect = mysqli_connect($host, $user, $password, $db);


if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $query = "SELECT * FROM order_details where status = '2' AND order_no LIKE '%" . $search . "%' OR status = '2' AND payment_id LIKE '%" . $search . "%' ";
} else {
    $query = "SELECT * FROM order_details where status = '2' ORDER BY cancelled_at desc";
}
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
?>
    <div class='table-responsive'>
        <table class='table  table-hover table-borderless'>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Cancelled Date</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['order_no']; ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($row['cancelled_at'])); ?></td>
                        <td>
                        <button onclick="ViewOrderDetails('<?php echo $row['id'];  ?>')" type="button" class='btn bg-primary text-white btn-md'>
                         <span class='fa fa-eye'></span> 
                        </button>

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