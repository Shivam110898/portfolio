<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);


// Check if the user is logged in, if not then redirect to login page
if(isset($_COOKIE['REMEMBER_ME'])) {
    // Decrypt cookie variable value
    $userid=decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser=$db->query('select * from admin_user where email = ?', $userid)->fetchAll();

    $count=count($getuser);

    if($count > 0) {
        $_SESSION['USER']=$userid;
    }
} else if(!isset($_COOKIE['REMEMBER_ME']) && !isset($_SESSION['USER'])) {
    header("location: /layouts/logout.php");
}



$ordersResult = $db->query('SELECT * FROM order_details  ')->fetchAll();
$pending = $db->query('SELECT * FROM order_details where status = ? ', '0')->fetchAll();
$completedsResult = $db->query('SELECT * FROM order_details where status = ?','1')->fetchAll();
$cancelled = $db->query('SELECT * FROM order_details where status = ?','2')->fetchAll();

include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>

<div class="container-fluid">
    <div class="maincontent">
    <div class="row ">

        <div class="col-sm-12">
            <div class="row ">
            <div class="col-md-4 ">
                <div class="page-header">
                    <h2><i class="fas fa-tasks"></i> Pending Orders : <?php echo count($pending)?></h2>
                </div>
                <div>
                    <div class="login" >
                        <input type="text" name="search_text" id="search_text" placeholder="Search"
                            class="form-control" />
                    </div>
                    <br />
                    <div id="result"></div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            LoadPendingDetails();
                            $('#search_text').keyup(function () {
                                var search = $(this).val();
                                if (search != '') {
                                    LoadPendingDetails(search);
                                } else {
                                    LoadPendingDetails();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="col-md-4">
                <div class="page-header">

                    <h2><i class="fas fa-mail-bulk"></i> Dispatched : <?php echo count($completedsResult); ?>
                    </h2>
                </div>
                <div>
                    <div class="login">
                        <input type="text" name="search_dispatched"  id="search_dispatched" placeholder="Search" class="form-control" />
                    </div>
                    <br />
                    <div id="dispatchresult"></div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            LoadDispatchedDetails();
                            $('#search_dispatched').keyup(function () {
                                var search = $(this).val();
                                if (search != '') {
                                    LoadDispatchedDetails(search);
                                } else {
                                    LoadDispatchedDetails();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="col-md-4">
                <div class="page-header">
                    <h2><i class="fas fa-close"></i> Cancelled : <?php echo count($cancelled); ?></h2>
                </div>
                <div>
                    <div class="login">
                        <input type="text" name="search_cancelled"  id="search_cancelled" placeholder="Search" class="form-control" />
                    </div>
                    <br />
                    <div id="cancelresult"></div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            LoadCancelledOrders();
                            $('#search_cancelled').keyup(function () {
                                var search = $(this).val();
                                if (search != '') {
                                    LoadCancelledOrders(search);
                                } else {
                                    LoadCancelledOrders();
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>