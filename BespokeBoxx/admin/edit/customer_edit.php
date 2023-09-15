<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/logics/logic.customers.php";
include_once $root . "/layouts/header.php";
include_once $root . "/layouts/sidebar.php";
?>
<div class="container-fluid">
    <div class="maincontent">
    <div class="row ">

    <div class="adminForm">
    <div class="page-header mb-4">
                <h1 class="mb-4" >Customer Profile: <?php echo $fetchedcustomer['first_name'];?> <?php echo $fetchedcustomer['last_name'];?>  </h1>
            </div>
            <div class="login" >
                           <div>
                    <p><?php echo $fetchedcustomer['first_name'];?> <?php echo $fetchedcustomer['last_name'];?> account details are below:</p>
                    <div class="table-responsive">
                        <table class='table table-borderless table-hover'>
                            <tr> 
                                <td>Username:</td>
                                <td><?= $fetchedcustomer['user_name'] ?></td>
                            </tr>
                            <tr>
                                <td>First name:</td>
                                <td><?= $fetchedcustomer['first_name'] ?></td>
                            </tr>
                            <tr>
                                <td>Last name:</td>
                                <td><?= $fetchedcustomer['last_name'] ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td  style="max-width:30px;"><?= $fetchedcustomer['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td  style="max-width:30px;"><?= $fetchedcustomer['phone_number'] ?></td>
                            </tr>
                            <tr>
                                <td>Registered At:</td>
                                <td><?= date("d/m/Y H:i:s", strtotime($fetchedcustomer['created_at']))?></td>
                            </tr>
                            <tr>
                                <td>Last Login:</td>
                                <td><?= $fetchedcustomer['last_login'] ?></td>
                            </tr>
                        </table>
                    </div>

                    <a href="/edit/password_edit.php?id=<?php echo $fetchedcustomer['id']; ?>" class="button" role="button"><span class="fas fa-pencil-alt"></span> Change Password</a>
                </div>  
        </div>
            <br />
            </div>

        </div>
    </div>
    
<?php
include_once $root . "/layouts/footer.php";
?>