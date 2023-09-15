<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function AlertMessage($message){
    echo "<script>ShowAlertBox('$message');</script>";
}

function ConfirmMessage($message){
    echo "<script>confirmDialog('$message');</script>";
}


function FormatInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = html_entity_decode($data);
    return $data;
}
function RightToForget($email, $db){
    $token = CreateGUID();
    $getUser = $db->query('SELECT * from user WHERE user_type_id = ? AND email=? and is_deleted = ?', 5, $email, 0)->fetchArray();
    if(count($getUser) > 0){
        $updateAddresses = $db->query("UPDATE user_address SET first_name = ?, last_name =? , phone_number = ?, address_line_1= ?, city = ?,
        country = ?, post_code = ? WHERE user_id=?",  $token, $token, $token, $token, $token, $token, $token, $getUser['id']);
        $update = $db->query("UPDATE user SET first_name = ? , last_name = ?, email= ?, password = ?,
        is_deleted = ?, status = ? WHERE id = ?",  $token, $token, $token, $token, 1, 0,$getUser['id']);
       
    }
}
function CreateGUID() { 
    $token      = $_SERVER['HTTP_HOST'];
    $token     .= $_SERVER['REQUEST_URI'];
    $token     .= uniqid(rand(), true);
    $hash        = strtoupper(md5($token));
    $guid        = '';  
    // GUID format is XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX for readability    
    $guid .= substr($hash,  0,  8) . '-' . substr($hash,  8,  4) . '-' . 
    substr($hash, 12,  4) . '-' . substr($hash, 16,  4) . '-' . substr($hash, 20, 12);
            
    return $guid;

}

function get_num_products_in_cart(){
    $q=0;
    if(isset($_SESSION['boxxproducts'])){
        foreach($_SESSION['boxxproducts'] as $value) {
            $q+=$value;
        }
    }
    return $q;
}
function get_bespokehamper_total($db){

    $price=0.00;
        
    if(isset($_SESSION['boxxsize'])){
        foreach($_SESSION['boxxsize'] as $id=>$quantity) {
            $products = $db->query('SELECT * FROM products where id=?', $id)->fetchArray();
            $price+=$products["price"];
        }
    }

    if(isset($_SESSION['boxxproducts'])){
        foreach($_SESSION['boxxproducts'] as $id=>$quantity) {

            $products = $db->query('SELECT * FROM products where id=?', $id)->fetchArray();
            if($quantity > 1){
                $price+=$products["price"]*$quantity;
            } else {
                $price+=$products["price"];
            }
        }
    }
    

    return number_format($price, 2); 
}
function get_subtotal($db){

    $price=0.00;
        
    if(isset($_SESSION['boxxsize'])){
        foreach($_SESSION['boxxsize'] as $id=>$quantity) {
            $products = $db->query('SELECT * FROM products where id=?', $id)->fetchArray();
            $price+=$products["price"];
        }
    }

    if(isset($_SESSION['boxxproducts'])){
        foreach($_SESSION['boxxproducts'] as $id=>$quantity) {

            $products = $db->query('SELECT * FROM products where id=?', $id)->fetchArray();
            if($quantity > 1){
                $price+=$products["price"]*$quantity;
            } else {
                $price+=$products["price"];
            }
        }
    }

    return number_format($price, 2); 
}

function get_total($db){

    $price=0.00;
    foreach ($_SESSION['Cart'] as $key => $value) { 
        foreach ($value as $sub_key => $sub_val) {                  
            if($sub_key == "total") {
                $price +=$sub_val;
            }
        }
    }

    return number_format($price, 2) + get_hotm_total($db); 
}

function get_discount_total($db){
    $price = 0.00;
    if(isset($_SESSION['discount'])){
        $discount = $db->query('SELECT * FROM discount WHERE description = ? AND status = ? AND is_deleted = ?', $_SESSION['discount'],'1','0')->fetchArray();
        if ($discount['discount_type'] == '%TAGE') {
            $discount_value = ($discount["discount_value"] / 100) * get_total($db);
            $price = get_total($db) - $discount_value;

        } else if ($discount['discount_type'] == 'AMOUNT')
            $discount_value = $discount["discount_value"];
            $price = get_total($db) - $discount_value;

    }
    
    return number_format($price, 2); 
}


function get_hotm_total($db){
    $price = 0.00;

    foreach ($_SESSION['botmBoxx'] as $key => $value) {
        foreach ($value as $sub_key => $sub_val) {
            if($sub_key == "productid") {
                $hotm = $db->query('SELECT * FROM products where id = ?', $sub_val)->fetchArray();
                $price += $hotm['price'];
            }
        }
            
    }
    
    return number_format($price, 2); 
}

function get_delivery_charges(){

    $price=0.00;
    foreach ($_SESSION['Cart'] as $key => $value) {
        foreach ($value as $sub_key => $sub_val) {
            if($sub_key == "total") {
                if($sub_val < 35.00){
                    $price += 4.99;
                }
            }
        }
            
    }
    foreach ($_SESSION['botmBoxx'] as $key => $value) {
        foreach ($value as $sub_key => $sub_val) {
            if($sub_key == "total") {
                if($sub_val < 35.00){
                    $price += 4.99;
                }
            }
        }
            
    }

    return number_format($price, 2); 
    
}



function get_gift_message_charges(){

    $price=0.00;
    foreach ($_SESSION['Cart'] as $key => $value) {
        foreach ($value as $sub_key => $sub_val) {
            if($sub_key == "gift_message") {
                $price += 1.49;
            }
        }
            
    }
    foreach ($_SESSION['botmBoxx'] as $key => $value) {
        foreach ($value as $sub_key => $sub_val) {
            if($sub_key == "gift_message") {
                $price += 1.49;
            }
        }
            
    }

    return number_format($price, 2); 
    
}

function get_grand_total($db){
    if(isset($_SESSION['discount'])){
        $grandTotal = get_discount_total($db) + get_delivery_charges()+ get_gift_message_charges();
        return number_format($grandTotal, 2); 
    } else {
        $grandTotal = get_total($db) + get_delivery_charges() + get_gift_message_charges() ;
        return number_format($grandTotal, 2); 
    }
}


function send_mail($to, $from, $subject, $message){
    $root = $_SERVER['DOCUMENT_ROOT'];
    require_once $root . "/vendor/autoload.php";

        //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'username';                     //SMTP username
        $mail->Password   = '********';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($from);
        $mail->addAddress($to);               //Name is optional
        $mail->addReplyTo($from);


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }


}

function clearBoxx(){
    unset($_SESSION['boxxsize']);
    unset($_SESSION['boxxfilling']);
    unset($_SESSION['boxxproducts']);
    unset($_SESSION['boxxCapacity']);
    unset($_SESSION['boxxcolour']);

}

function clearCart(){
    clearBoxx();
    unset($_SESSION['Cart']);
    unset($_SESSION['boxxQuantity']);
    unset($_SESSION['giftMessage']);
    unset($_SESSION['deliveryAddress']);
    unset($_SESSION['recepientName']);
    unset($_SESSION['botmBoxx']);
    unset($_SESSION["GUEST_LOGIN"]);
    unset($_SESSION["discount"]);
    unset($_SESSION['itemsLeft']);
    unset($_SESSION['boxxEditId']);
    unset($_SESSION['delivery_address_count']);
    unset($_SESSION['sideCartVisible']);
    unset($_SESSION['lastOrderId']);
    
}

function cleanseUselessUserData($db){
    $Users = $db->query('SELECT * FROM user where user_type_id = ?', 6)->fetchAll();
    foreach($Users as $user){
        $orders = $db->query('SELECT * FROM order_details where user_id = ?', $user['id'])->fetchAll();
        if(count($orders) == 0)
        {
            $deleteAddress = $db->query('DELETE FROM user_address where user_id = ?', $user['id']);
            $deleteUser = $db->query('DELETE FROM user where id = ?', $user['id']);
        }
    }
}



?>