<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function AlertMessage($message){
    echo "<script>alert('$message');</script>";
}

function ConfirmMessage($message){
    echo "<script>confirm('$message');</script>";
}


function FormatInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = html_entity_decode($data);
    return $data;
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
function DeleteImagesNotInTheDB($db){
    $frontdirectory = "/Users/shivam/Sites/test/uploadedimgs";
    //$frontdirectory = "/kunden/homepages/46/d879533653/htdocs/test/uploadedimgs/";
    $backenddirectory = "/Users/shivam/Sites/admin/uploadedimgs";
    $foldersToDeleteFrom = array($frontdirectory, $backenddirectory);
    foreach($foldersToDeleteFrom as $directory ){
        chdir($directory);
        $images = glob("*.{jpg,JPG,jpeg,JPEG,png,PNG,heic}", GLOB_BRACE);
        foreach($images as $image)
        {
            $sql = $db->query( "SELECT id FROM products where image='$image' and is_deleted=1")->fetchArray();
            if(count($sql) > 0)
            {
                unlink("{$directory}/{$image}");
            }
        }
    }
    
}

// Encrypt cookie
function encryptCookie( $value ) {

    $key = hex2bin(openssl_random_pseudo_bytes(4));
 
    $cipher = "aes-256-cbc";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
 
    $ciphertext = openssl_encrypt($value, $cipher, $key, 0, $iv);
 
    return( base64_encode($ciphertext . '::' . $iv. '::' .$key) );
 }
 
 // Decrypt cookie
 function decryptCookie( $ciphertext ) {
 
    $cipher = "aes-256-cbc";
 
    list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
    return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
 
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

function DeleteAllUsersAndAddresses($db){
    $deleteAddress = $db->query('DELETE FROM user_address ');
    $deleteUser = $db->query('DELETE FROM user');
}

function DeleteAllOrderDetails($db){
    $deleteAddress = $db->query('DELETE FROM delivery_addresses');
    $messages = $db->query('DELETE FROM gift_messages');
    $messages = $db->query('DELETE FROM order_items');
    $messages = $db->query('DELETE FROM order_details');
}

function CleanseTestData($db){
    $deletevisitlog = $db->query('DELETE FROM visitor_activity_logs');
    DeleteAllOrderDetails($db);
    DeleteAllUsersAndAddresses($db);

}

function ReplenishTestDataStock($db){
    $orders = $db->query('SELECT * FROM order_details')->fetchAll();
    foreach($orders as $order){
        $getItemsInOrder = $db->query('SELECT * FROM order_items where order_id = ?',$order['id'])->fetchAll();
        foreach($getItemsInOrder as $item ){
            $updateQuantity = $db->query('UPDATE products SET quantity = quantity + ? where id = ?',$item['quantity'],$item['product_id']);

        }
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
        $mail->Username   = 'dsd@m.com';                     //SMTP username
        $mail->Password   = '*******';                               //SMTP password
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

 ?>