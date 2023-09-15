<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["CUSTOMER_LOGIN"]) || $_SESSION["CUSTOMER_LOGIN"] === '') {
    header("location: /views/logout.php");
    exit;
}


$profileResult = $db->query('SELECT * FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();

include_once $root . "/views/header.php";
?>
<div class="site-section" data-aos="fade-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="site-section-heading">Your Address Book</div>
            </div>
            <div class="col-md-8">

                <?php $addressRes = $db->query('SELECT * FROM user_address where user_id = ? and is_deleted = ? ORDER BY created_at', $profileResult['id'],'0' )->fetchAll();
                    if (count($addressRes) > 0) { ?>
                <div class='table-responsive'>
                    <table class='table table-borderless table-hover'>
                        <thead>
                            <tr>
                                <th>Address Line 1</th>
                                <th>Address Line 2</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ( $addressRes as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['address_line_1']; ?></td>
                                <td><?php echo $row['address_line_2']; ?></td>
                                <td><?php echo $row['city']; ?></td>
                                <td><?php echo $row['post_code']; ?></td>
                                <td>
                                    <button onclick="EditAddress('<?php echo $row['id'];  ?>',);" type='button'
                                        class='btn btn-dark btn-md '>
                                        <span class='icon-pencil'></span>
                                    </button>
                                    <button
                                        onclick="Delete('<?php echo $row['id'];  ?>','/logics/logic.customer.php');"
                                        type='button' class='btn btn-danger btn-md'>
                                        <span class='icon-trash'></span>
                                    </button>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                    <p class='lead'><em>You have no addresses saved.</em></p>
                    <?php }?>
            </div>
            <div class="col-md-4 ml-auto">
                <?php include_once $root . "/views/customermenu.php";?>
            </div>
        </div>
    </div>
</div>

<?php
    include_once $root . "/views/footer.php";
    ?>