<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
$db = new Database($host, $user, $password, $db);


// Check if the user is logged in, if not then redirect to login page
if(isset($_COOKIE['REMEMBER_ME'] )){
 
    // Decrypt cookie variable value
    $userid = decryptCookie($_COOKIE['REMEMBER_ME']);
    $getuser = $db->query('select * from admin_user where email = ?', $userid)->fetchAll();

    $count = count($getuser);
  
    if( $count > 0 ){
       $_SESSION['USER'] = $userid; 
    }
} else if(!isset($_SESSION['USER'] )){
    header("location: /layouts/logout.php");


}

$sitecount = $db->query('SELECT * FROM visitor_activity_logs order by created_on DESC')->fetchAll();



include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>

<div class="container-fluid">
    <div class="maincontent">
        <div class="row ">
            <div class="col-sm-6">
                <div class="page-header">
                    <h1>Visitor Activity Log</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header">
                    <h1>Site Visits : <?php echo count($sitecount);?></h1>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12 ">
                <div class='table-responsive'>
                    <table class='table table-borderless '>
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Device</th>
                                <th>Page</th>
                                <th>Count</th>
                                <th>Visited On</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($sitecount as $sitecounts) { ?>

                            <tr>
                                <td><?php echo $sitecounts['user_ip_address']; ?></td>
                                <td><?php echo $sitecounts['user_agent']; ?></td>
                                <td><?php echo $sitecounts['page_url']; ?></td>
                                <td><?php echo $sitecounts['count']; ?></td>
                                <td><?php echo date("d/m/Y H:i:s", strtotime($sitecounts['created_on'])); ?></td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once $root . "/layouts/footer.php";
?>