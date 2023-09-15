<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";
include $root . "/layouts/header.php";
$db = new Database($host, $user, $password, $db);

// Check if $_SESSION or $_COOKIE already set
if(isset($_COOKIE['REMEMBER_ME']) ){
     // Decrypt cookie variable value
     $userid=decryptCookie($_COOKIE['REMEMBER_ME']);
     $getuser=$db->query('select * from admin_user where email = ?', $userid)->fetchArray();
 
     $count=count($getuser);
 
     if($count > 0) {
         $_SESSION['USER']=$userid;
     }
	header('location: /layouts/dashboard.php');
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="adminForm">
                <div class="page-header">
                    <h2>Login</h2>
                </div>
                <form  id="loginForm">

                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <label for="email" class="text-black"><span class="fas fa-lock"></span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="text-black"> <span class="fas fa-lock"></span></label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>

                        </div>
                        <div class="form-group row">
                            <span for="rememberme" class="text-black">Remember me? </span> 
                            <input type="checkbox" class="form-control"  name="rememberme" value="1">

                        </div>
                        <div class="form-group row">
                            <input type="submit" onclick="return UserLogin();" class="btn  btn-pink btn-block" value="SIGN IN">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>