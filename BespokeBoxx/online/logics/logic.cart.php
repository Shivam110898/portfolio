<?php
use Stripe\Quote;

session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/helpers/Database.php";
require_once $root . "/helpers/config.php";
$db = new Database($host, $user, $password, $db);
require_once $root . "/helpers/functions.php";

if (isset($_POST['product_id']) && isset($_POST['product_type']))
{
    $product_id = $_POST['product_id'];
    $product_type = $_POST['product_type'];
    $quantity = 1;
    $product = $db->query('SELECT id,name FROM products where id = ?', $product_id)->fetchArray();
    if (count($product) > 0)
    {
        if ($product_type == "BoxxColour")
        {
            if (isset($_SESSION['boxxcolour']))
            {
                $_SESSION['boxxcolour'] = array($product_id => $quantity);
                $getSetHamperColour = $db->query('SELECT name, image FROM products where id = ? ', $product_id)->fetchArray();
                if (isset($_SESSION['boxxsize'])){
                    foreach($_SESSION['boxxsize'] as $id=>$q){
                        $getIsSetBoxxSize = $db->query('SELECT property_value FROM product_properties where product_id = ? AND property_name = ?', $id, 'Boxx_Size')->fetchArray();
                        
                    }
                    $hampers = $db->query('SELECT id FROM products where id IN (SELECT product_id FROM products_to_category WHERE category_id=3 ) ORDER BY visibility_order asc')->fetchAll();

                    foreach($hampers as $hamper) {
                        $getColour = $db->query('SELECT property_value FROM product_properties where product_id = ? AND property_name = ?', $hamper['id'], 'Colour')->fetchArray();
                        $getSize = $db->query('SELECT property_value FROM product_properties where product_id = ? AND property_name = ?', $hamper['id'], 'Boxx_size')->fetchArray();
                        if($getSetHamperColour['name'] == $getColour['property_value']){
                            if($getIsSetBoxxSize['property_value'] == $getSize['property_value']){
                                $_SESSION['boxxsize'] = array(
                                    $hamper['id'] => $quantity
                                );
                            }
                        }
                    }
                }

                echo "addedToCart";
            }
            else
            {
                $_SESSION['boxxcolour'] = array(
                    $product_id => $quantity
                );
                echo "addedToCart";
            }

        }

        if ($product_type == "BoxxSize")
        {
            if (isset($_SESSION['boxxsize']))
            {
                if (isset($_SESSION['boxxproducts']))
                {

                     $_SESSION['boxxFutureCapacity'] += 5;
                    if ($product["name"] == "Small")
                    {
                        foreach ($_SESSION['boxxproducts'] as $id => $q)
                        {
                            $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsSmall')->fetchArray();
                            if ($q > 1)
                            {
                                $_SESSION['boxxFutureCapacity'] += $fillsHamper["property_value"] * $q;

                            }
                            else if ($q == 1)
                            {
                                $_SESSION['boxxFutureCapacity'] += $fillsHamper["property_value"];
                            }
                        }
                        if ($_SESSION['boxxFutureCapacity']  > 100)
                        {
                            unset($_SESSION['boxxFutureCapacity']);

                            echo "moreProductsThanLimit";
                        }
                        else
                        {
                        
                            $_SESSION['boxxsize'] = array(
                                $product_id => $quantity
                            );

                            $_SESSION["boxxCapacity"] = $_SESSION['boxxFutureCapacity'];
                            unset($_SESSION['boxxFutureCapacity']);
                            echo "sizeAlreadyaddedToCart";

                        }

                    }
                    else if ($product["name"] == "Medium")
                    {
                        foreach ($_SESSION['boxxproducts'] as $id => $q)
                        {
                            $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsMedium')->fetchArray();
                            if ($q > 1)
                            {
                                $_SESSION['boxxFutureCapacity'] += $fillsHamper["property_value"] * $q;

                            }
                            else if ($q == 1)
                            {
                                $_SESSION['boxxFutureCapacity'] += $fillsHamper["property_value"];
                            }
                        }
                        if ($_SESSION['boxxFutureCapacity'] > 100)
                        {
                            unset($_SESSION['boxxFutureCapacity']);
                            echo "moreProductsThanLimit";
                        }
                        else
                        {
                            
                            $_SESSION['boxxsize'] = array(
                                $product_id => $quantity
                            );

                            $_SESSION["boxxCapacity"] = $_SESSION['boxxFutureCapacity'];
                            unset($_SESSION['boxxFutureCapacity']);
                            echo "sizeAlreadyaddedToCart";
                        }

                    }
                    else if ($product["name"] == "Large")
                    {
                        foreach ($_SESSION['boxxproducts'] as $id => $q)
                        {
                            $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsLarge')->fetchArray();
                            if ($q > 1)
                            {
                                $_SESSION['boxxFutureCapacity'] += $fillsHamper["property_value"] * $q;

                            }
                            else if ($q == 1)
                            {
                                $_SESSION['boxxFutureCapacity'] += $fillsHamper["property_value"];
                            }
                        }
                        if ($_SESSION['boxxFutureCapacity'] > 100)
                        {
                            unset($_SESSION['boxxFutureCapacity']);
                            echo "moreProductsThanLimit";
                        }
                        else
                        {
                            
                            $_SESSION['boxxsize'] = array(
                                $product_id => $quantity
                            );

                            $_SESSION["boxxCapacity"] = $_SESSION['boxxFutureCapacity'];
                            unset($_SESSION['boxxFutureCapacity']);
                            echo "sizeAlreadyaddedToCart";
                        }

                    }

                }
                else
                {
                    
                    $_SESSION['boxxsize'] = array(
                        $product_id => $quantity
                    );

                    echo "addedToCart";
                }

            }
            else
            {

                $_SESSION['boxxsize'] = array(
                    $product_id => $quantity
                );

                echo "addedToCart";
            }

        }
        if ($product_type == "BoxxFilling")
        {
            if (isset($_SESSION['boxxfilling']))
            {
                if (count($_SESSION['boxxfilling']) == 2)
                {
                    echo "maxFillingReached";
                }
                else
                {
                    if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                    {
                        // Product exists in cart
                        echo "exists";
                    }
                    else
                    {               

                        // Product is not in cart so add it
                        $_SESSION['boxxfilling'][$product_id] = $quantity;

                        echo "fillingaddedToCart";
                    }
                }
            }
            else
            {
                $_SESSION['boxxfilling'] = array(
                    $product_id => $quantity
                );
                $_SESSION['boxxCapacity'] += 5;

                echo "fillingaddedToCart";
            }
        }
        if ($product_type == "products")
        {
            if (isset($_SESSION['boxxproducts']))
            {
                foreach ($_SESSION['boxxsize'] as $key => $value)
                {
                    $gethampersize = $db->query('SELECT name FROM products where id = ? ', $key)->fetchArray();
                    if ($gethampersize["name"] == "Small")
                    {
                        $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $product_id, 'FillsSmall')->fetchArray();
                        if ($_SESSION['boxxCapacity'] < 100)
                        {
                            $_SESSION['boxxCapacity'] += $fillsHamper["property_value"];
                            if ($_SESSION['boxxCapacity'] > 100)
                            {
                                $_SESSION['boxxCapacity'] -= $fillsHamper["property_value"];

                                echo "maxReached";
                            }
                            else
                            {
                                if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                                {

                                    // Product exists in cart
                                    $_SESSION['boxxproducts'][$product_id] += $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";

                                }
                                else
                                {
                                    // Product is not in cart so add it
                                    $_SESSION['boxxproducts'][$product_id] = $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";
                                }
                            }

                        }
                        else
                        {
                            echo "maxReached";

                        }
                    }
                    else if ($gethampersize["name"] == "Medium")
                    {
                        $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $product_id, 'FillsMedium')->fetchArray();
                        if ($_SESSION['boxxCapacity'] < 100)
                        {
                            $_SESSION['boxxCapacity'] += $fillsHamper["property_value"];
                            if ($_SESSION['boxxCapacity'] > 100)
                            {
                                $_SESSION['boxxCapacity'] -= $fillsHamper["property_value"];

                                echo "maxReached";
                            }
                            else
                            {
                                if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                                {
                                    // Product exists in cart
                                    $_SESSION['boxxproducts'][$product_id] += $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    
                                    echo "productaddedToCart";

                                }
                                else
                                {
                                    // Product is not in cart so add it
                                    $_SESSION['boxxproducts'][$product_id] = $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";
                                }
                            }

                        }
                        else
                        {
                            echo "maxReached";

                        }
                    }
                    else if ($gethampersize["name"] == "Large")
                    {
                        $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $product_id, 'FillsLarge')->fetchArray();
                        if ($_SESSION['boxxCapacity'] < 100)
                        {
                            $_SESSION['boxxCapacity'] += $fillsHamper["property_value"];
                            if ($_SESSION['boxxCapacity'] > 100)
                            {
                                $_SESSION['boxxCapacity'] -= $fillsHamper["property_value"];

                                echo "maxReached";
                            }
                            else
                            {
                                if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                                {
                                    // Product exists in cart
                                    $_SESSION['boxxproducts'][$product_id] += $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    
                                    echo "productaddedToCart";

                                }
                                else
                                {
                                    // Product is not in cart so add it
                                    $_SESSION['boxxproducts'][$product_id] = $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";
                                }
                            }

                        }
                        else
                        {
                            echo "maxReached";

                        }
                    }

                }
            }
            else
            {
                foreach ($_SESSION['boxxsize'] as $key => $value)
                {
                    $gethampersize = $db->query('SELECT name FROM products where id = ? ', $key)->fetchArray();
                    if ($gethampersize["name"] == "Small")
                    {
                        $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $product_id, 'FillsSmall')->fetchArray();
                        if ($_SESSION['boxxCapacity'] < 100)
                        {
                            $_SESSION['boxxCapacity'] += $fillsHamper["property_value"];
                            if ($_SESSION['boxxCapacity'] > 100)
                            {
                                $_SESSION['boxxCapacity'] -= $fillsHamper["property_value"];

                                echo "maxReached";
                            }
                            else
                            {
                                if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                                {
                                    // Product exists in cart
                                    $_SESSION['boxxproducts'][$product_id] += $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";

                                }
                                else
                                {
                                    // Product is not in cart so add it
                                    $_SESSION['boxxproducts'][$product_id] = $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    
                                    
                                    echo "productaddedToCart";
                                }
                            }

                        }
                        else
                        {
                            echo "maxReached";

                        }
                    }
                    else if ($gethampersize["name"] == "Medium")
                    {
                        $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $product_id, 'FillsMedium')->fetchArray();
                        if ($_SESSION['boxxCapacity'] < 100)
                        {
                            $_SESSION['boxxCapacity'] += $fillsHamper["property_value"];
                            if ($_SESSION['boxxCapacity'] > 100)
                            {
                                $_SESSION['boxxCapacity'] -= $fillsHamper["property_value"];

                                echo "maxReached";
                            }
                            else
                            {
                                if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                                {
                                    // Product exists in cart
                                    $_SESSION['boxxproducts'][$product_id] += $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";

                                }
                                else
                                {
                                    // Product is not in cart so add it
                                    $_SESSION['boxxproducts'][$product_id] = $quantity;
                                    
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";
                                }
                            }

                        }
                        else
                        {
                            echo "maxReached";

                        }
                    }
                    else if ($gethampersize["name"] == "Large")
                    {
                        $fillsHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $product_id, 'FillsLarge')->fetchArray();
                        if ($_SESSION['boxxCapacity'] < 100)
                        {
                            $_SESSION['boxxCapacity'] += $fillsHamper["property_value"];
                            if ($_SESSION['boxxCapacity'] > 100)
                            {
                                $_SESSION['boxxCapacity'] -= $fillsHamper["property_value"];

                                echo "maxReached";
                            }
                            else
                            {
                                if (array_key_exists($product_id, $_SESSION['boxxproducts']))
                                {
                                    // Product exists in cart
                                    $_SESSION['boxxproducts'][$product_id] += $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    echo "productaddedToCart";

                                }
                                else
                                {
                                    // Product is not in cart so add it
                                    $_SESSION['boxxproducts'][$product_id] = $quantity;
                                    $_SESSION['itemsLeft'][$product_id] += $quantity;

                                    
                                    echo "productaddedToCart";
                                }
                            }

                        }
                        else
                        {
                            echo "maxReached";

                        }
                    }

                }
            }
        }
    }
}

if (isset($_GET['Del']) && isset($_GET['Type']))
{
    $quantity = 1;
    if ($_GET['Type'] == "Product")
    {
        if (array_key_exists($_GET['Del'], $_SESSION['boxxproducts']))
        {

            foreach ($_SESSION['boxxproducts'] as $id => $value)
            {
                if ($id == $_GET['Del'])
                {
                    foreach ($_SESSION["boxxsize"] as $cartid => $q)
                    {
                        $gethampersize = $db->query('SELECT name FROM products where id = ? ', $cartid)->fetchArray();
                        if ($gethampersize["name"] == "Small")
                        {
                            $fillsSmallHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsSmall')->fetchArray();
                            $_SESSION['boxxCapacity'] -= $fillsSmallHamper["property_value"];
                            
                        }
                        else if ($gethampersize["name"] == "Medium")
                        {
                            $fillsMediumHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsMedium')->fetchArray();
                            $_SESSION['boxxCapacity'] -= $fillsMediumHamper["property_value"];
                        }
                        else if ($gethampersize["name"] == "Large")
                        {
                            $fillsLargeHamper = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsLarge')->fetchArray();
                            $_SESSION['boxxCapacity'] -= $fillsLargeHamper["property_value"];

                        }
                    }

                    if ($value == 1)
                    {
                        unset($_SESSION['boxxproducts'][$_GET['Del']]);
                        unset($_SESSION['Cart'][$_GET['Del']]);
                        $_SESSION['itemsLeft'][$_GET['Del']] -= $quantity;

                        if (count($_SESSION['boxxproducts']) == 0)
                        {
                            unset($_SESSION['boxxproducts']);

                        }
                        echo "removed";

                    } else {
                        $_SESSION['boxxproducts'][$_GET['Del']] -= $quantity;
                        $_SESSION['itemsLeft'][$_GET['Del']] -= $quantity;

                        if (count($_SESSION['boxxproducts']) == 0)
                        {
                            unset($_SESSION['boxxproducts']);   

                        }
                        echo "removed";

                    }
                }
            }
        }
        else if (count($_SESSION['boxxproducts']) == 0)
        {
            unset($_SESSION['boxxproducts']);
        }
    }
    else if ($_GET['Type'] == "GiftMessage")
    {

        unset($_SESSION['giftMessage']);
        echo "removed";

    }
    else if ($_GET['Type'] == "Filling")
    {
        if (array_key_exists($_GET['Del'], $_SESSION['boxxfilling']))
        {
            if (count($_SESSION['boxxfilling']) > 1)
            {
                unset($_SESSION['boxxfilling'][$_GET['Del']]);
                echo "fillingremoved";
            }
            else if (count($_SESSION['boxxfilling']) == 1)
            {
                echo "minimum1filling";
            }

        }
    }
    else if ($_GET['Type'] == "Discount")
    {
        unset($_SESSION['discount']);
        echo "removed";
    }
    else if ($_GET['Type'] == "Boxx")
    {
        foreach ($_SESSION['Cart'] as $key => $value) { 
            if($_GET['Del'] == $key) {
                foreach ($value as $sub_key => $sub_val) {
                    if (is_array($sub_val)) { 
                        foreach ($sub_val as $k => $v) {
                            if($sub_key == "products") {
                                $_SESSION['itemsLeft'][$k] -= $v;

                            }
                        }
                    }
                }
            }
        }
        foreach ($_SESSION['Cart'] as $key => $value) { 
            if($_GET['Del'] == $key) {
                if(array_key_exists("delivery_address_id", $value)) {                
                    if ($_SESSION['delivery_address_count']>0){
                        $_SESSION['delivery_address_count']-=1;
                    } else if ($_SESSION['delivery_address_count']==0){
                        unset($_SESSION['delivery_address_count']);  
                    }
                }
                unset($_SESSION['Cart'][$key]);
                $_SESSION['boxxQuantity']--;
                $_SESSION['sideCartVisible'] = true;
                
            } 
        }
        
        if(count($_SESSION['Cart']) == 0 && count($_SESSION['botmBoxx']) > 0){
            unset($_SESSION['Cart']);
        } else if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) == 0){
           clearCart();
        }
        echo "removed";
    } 
    else if ($_GET['Type'] == "GiftmessageForBoxx")
    {
        unset($_SESSION['Cart'][$_GET['Del']]['gift_message']);;
    } 
    else if ($_GET['Type'] == "GiftmessageForBOTM")
    {
        unset($_SESSION['botmBoxx'][$_GET['Del']]['gift_message']);;
    } else if ($_GET['Type'] == "BOTM")
    {
        foreach ($_SESSION['botmBoxx'] as $key => $value) { 
            if($_GET['Del'] == $key) {
                if(array_key_exists("delivery_address_id", $value)) {                
                    if ($_SESSION['delivery_address_count']>0){
                        $_SESSION['delivery_address_count']-=1;
                    } else if ($_SESSION['delivery_address_count']==0){
                        unset($_SESSION['delivery_address_count']);  
                    }
                }
                foreach ($value as $sub_key => $sub_val) {
                    if($sub_key == 'productid'){
                        $_SESSION['itemsLeft'][$sub_val] -= 1;
                    }
                    if($_SESSION['itemsLeft'][$sub_val] == 0){
                        unset($_SESSION['itemsLeft'][$sub_val]);
                    }
                }
                unset($_SESSION['botmBoxx'][$key]);
                $_SESSION['boxxQuantity']--;
                $_SESSION['sideCartVisible'] = true;
            } 
        }
        if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) > 0){
            unset($_SESSION['botmBoxx']);
        } else if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) == 0){
            clearCart();
        }

        echo "removed";
    }
}

if(isset($_GET['edit_boxx'])){
    $boxxrid = $_GET['edit_boxx'];
    foreach ($_SESSION['Cart'] as $key => $value) { 
        
        if($boxxrid == $key) {
            unset($_SESSION['Cart'][$boxxrid]['delivery_address_id']);  
            if(array_key_exists("delivery_address_id", $value)) {                

                if ($_SESSION['delivery_address_count']>0){
                    $_SESSION['delivery_address_count']-=1;
                } else if ($_SESSION['delivery_address_count']==0){
                    unset($_SESSION['delivery_address_count']);  
                }
            }
            
            foreach ($value as $sub_key => $sub_val) {
                if (is_array($sub_val)) { 
                    foreach ($sub_val as $k => $v) {
                        if($sub_key == "colour") {
                            $_SESSION['boxxcolour'][$k] = $v;

                        }
                        if($sub_key == "size") {
                            $_SESSION['boxxsize'][$k] = $v;

                        }
                        if($sub_key == "filling") {
                            $_SESSION['boxxfilling'][$k] = $v;

                        }
                        if($sub_key == "products") {
                            $_SESSION['boxxproducts'][$k] = $v;

                        }
                        

                    }
                    
                }
                
            } 
            $cartCapacity = 5;
            foreach($_SESSION['boxxsize'] as $key=>$value) {
                $product = $db->query('SELECT name FROM products where id = ?', $key)->fetchArray();
                if ($product["name"] == "Small") {
                    foreach($_SESSION['boxxproducts'] as $id=>$quantity) {
                        $fillsHamperby = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsSmall')->fetchArray();
                        $cartCapacity += $fillsHamperby['property_value'] * $quantity;  
                    }
                } else if ($product["name"] == "Medium") {
                    foreach($_SESSION['boxxproducts'] as $id=>$quantity) {
                        $fillsHamperby = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsMedium')->fetchArray();
                        $cartCapacity += $fillsHamperby['property_value'] * $quantity;  
                    } 
                } else if ($product["name"] == "Large") { 
                    foreach($_SESSION['boxxproducts'] as $id=>$quantity) {
                        $fillsHamperby = $db->query('SELECT property_value FROM product_properties where product_id = ? and property_name = ?', $id, 'FillsLarge')->fetchArray();
                        $cartCapacity += $fillsHamperby['property_value'] * $quantity;  
                        
                    }

                }

            }
            $_SESSION['boxxCapacity'] = $cartCapacity;
            $_SESSION['sideCartVisible'] = false;

            $_SESSION['boxxEditId'] = $boxxrid;
            echo "hamperToBeEdited";

        }
                
    }
}

if (isset($_GET['AddBoxxToCart']))
{
    $boxxrid = $_GET['AddBoxxToCart'];
    if (isset($_SESSION['Cart']))
    {
        if(array_key_exists($boxxrid, $_SESSION['Cart']))
        {
            $_SESSION['Cart'][$boxxrid] = array( 
                "colour" => $_SESSION['boxxcolour'], 
                "size" =>  $_SESSION["boxxsize"],
                "filling" => $_SESSION["boxxfilling"],
                "products" => $_SESSION['boxxproducts'],
                "total" => get_subtotal($db),
            );
            clearBoxx();
            unset($_SESSION['boxxEditId']);
            unset($_SESSION['Cart'][$boxxrid]['delivery_address_id']);    
            $_SESSION['sideCartVisible'] = true;
            echo "boxxAddedToCart";
        } else {
            if($_SESSION['boxxQuantity'] == 3){
                echo "maxReached";
            } else {
                $_SESSION['Cart'][$boxxrid] = array( 
                    "colour" => $_SESSION['boxxcolour'], 
                    "size" =>  $_SESSION["boxxsize"],
                    "filling" => $_SESSION["boxxfilling"],
                    "products" => $_SESSION['boxxproducts'],
                    "total" => number_format(get_subtotal($db),2),
                    

                    );
                    clearBoxx();

                
                $_SESSION['boxxQuantity']++;
                $_SESSION['sideCartVisible'] = true;

                echo "boxxAddedToCart";
            }
        }
    }
    else
    {
        if($_SESSION['boxxQuantity'] == 3){
            echo "maxReached";
        } else {
            $_SESSION['Cart'][$boxxrid] = array( 
                "colour" => $_SESSION['boxxcolour'], 
                "size" =>  $_SESSION["boxxsize"],
                "filling" => $_SESSION["boxxfilling"],
                "products" => $_SESSION['boxxproducts'],
                "total" => number_format(get_subtotal($db),2),
            );
            clearBoxx();
            
            $_SESSION['sideCartVisible'] = true;
            $_SESSION['boxxQuantity']++;
            echo "boxxAddedToCart";
        }
    }
}

if(isset($_GET['botmid']) && isset($_GET['product_id'])){
    $hotm_id = $_GET['botmid'];
    $product_id = $_GET['product_id'];
    $hotm = $db->query('SELECT id, price FROM products where id = ? ', $product_id)->fetchArray();
    if (isset($_SESSION['botmBoxx']))
    {
        if($_SESSION['boxxQuantity'] == 3){
            echo "maxReached";
        } else {
            $_SESSION['botmBoxx'][$hotm_id] = array( 
                "productid" => $product_id,
                "total" => $hotm['price'],
            );
            $_SESSION['itemsLeft'][$product_id] += 1;
            $_SESSION['boxxQuantity']++;
            $_SESSION['sideCartVisible'] = true;
            echo "botmAdded";
        }
    } else {
        if($_SESSION['boxxQuantity'] == 3){
            echo "maxReached";
        } else {
            $_SESSION['botmBoxx'][$hotm_id] = array( 
                "productid" => $product_id,
                "total" => $hotm['price'],
            );
            $_SESSION['itemsLeft'][$product_id] += 1;
            $_SESSION['boxxQuantity']++;
            $_SESSION['sideCartVisible'] = true;
            echo "botmAdded";
        }
    }
}

if (isset($_GET['address_id']) && isset($_GET['boxx_id']) && isset($_GET['type']))
{
    if($_GET['type'] == "bespoke"){
        $address_id = $_GET['address_id'];
        $boxx_id = $_GET['boxx_id'];
        $address = $db->query('SELECT id FROM user_address where id = ?', $address_id)->fetchArray();
        if (count($address) > 0)
        {
            $_SESSION['Cart'][$boxx_id]['delivery_address_id'] = $address_id;
            echo "addressAdded";
        }
    } else if($_GET['type'] == "hotm"){
        $address_id = $_GET['address_id'];
        $boxx_id = $_GET['boxx_id'];
        $address = $db->query('SELECT id FROM user_address where id = ?', $address_id)->fetchArray();
        if (count($address) > 0)
        {
            $_SESSION['botmBoxx'][$boxx_id]['delivery_address_id'] = $address_id;
            echo "addressAdded";
        }
    }
}

if (isset($_POST['giftMessage']) && isset($_POST['boxx_id']) && isset($_POST['type']))
{
    if($_POST['type'] == "bespoke"){
        $giftmessage = $_POST['giftMessage'];
        $boxx_id = $_POST['boxx_id'];
        $_SESSION['Cart'][$boxx_id]['gift_message'] = $giftmessage;
        echo "messageSet";
    } else if($_POST['type'] == "hotm") {
        $giftmessage = $_POST['giftMessage'];
        $boxx_id = $_POST['boxx_id'];
        $_SESSION['botmBoxx'][$boxx_id]['gift_message'] = $giftmessage;
        echo "messageSet";
    }
    
}

if (isset($_GET['submit_payment']))
{
    $paymentId = $_GET['submit_payment'];
    $total = get_grand_total($db);
    $order_no = "BBXX".rand(000000,999999);
    $currentDate=date("Y-m-d H:i:s");

    if (isset($_SESSION["CUSTOMER_LOGIN"]))
    {
        $Customer = $db->query('SELECT id,first_name,last_name,email FROM user WHERE email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();
        $insertOrderDetails = $db->query('INSERT INTO order_details (order_no, user_id, payment_id, total, discount_applied, status,created_at) values (?,?,?,?,?,?,?)', $order_no, $Customer['id'], $paymentId, $total,$_SESSION['discount'] , '0',$currentDate);
        if ($insertOrderDetails->affectedRows() > 0) {
            $lastOrderId = $db->lastInsertID();
            $_SESSION['lastOrderId'] = $db->lastInsertID();
            foreach ($_SESSION['Cart'] as $key => $value) { 
                foreach ($value as $sub_key => $sub_val) {
                    if (is_array($sub_val)) { 
                        foreach ($sub_val as $k => $v) {
                            if($sub_key == "colour") {
                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'colour',$v,$currentDate);
                                
                            }
                            if($sub_key == "size") {

                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'size',$v,$currentDate);
                                $reduceStock = $db->query('UPDATE products SET quantity = quantity - ? WHERE id = ?',  $v, $k );
                                $fetchProductAfterDec = $db->query('SELECT id,quantity FROM products where id=?', $k)->fetchArray();
                                if($fetchProductAfterDec["quantity"] == 0){
                                    $setStatusOutOfStock = $db->query('UPDATE products SET status = ? WHERE id = ?','0',$k );
                                } 
                            }
                            if($sub_key == "filling") {
                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'filling',$v,$currentDate);
    
                            }
                            if($sub_key == "products") {
                                
                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'product',$v,$currentDate);
                                $reduceStock = $db->query('UPDATE products SET quantity = quantity - ? WHERE id = ?',$v, $k );
                                $fetchProductAfterDec = $db->query('SELECT quantity FROM products where id=?', $k)->fetchArray();
                                if($fetchProductAfterDec["quantity"] == 0){
                                    $setStatusOutOfStock = $db->query('UPDATE products SET status = ? WHERE id = ?','0',$k );
                                } 
                            }
                        }
                    } else {
                        $boxxtotal;
                        if($sub_key == 'total') {
                            $boxxtotal = $sub_val;
                        }
                        if($sub_key == 'delivery_address_id') {
                            $insertOrderItems = $db->query('INSERT INTO delivery_addresses (address_id, hamper_id, hamper_total) values (?,?,?)', $sub_val, $key,$boxxtotal);
                        }
                        if($sub_key == 'gift_message') {
                            $insertOrderItems = $db->query('INSERT INTO gift_messages (message, hamper_id) values (?,?)', $sub_val, $key);
                        }
                    }
                }
                        
            }
            foreach ($_SESSION['botmBoxx'] as $key => $value)
            {
                foreach ($value as $sub_key => $sub_val) {
                    $id;
                    if($sub_key == 'productid') {
                        $id = $sub_val;
                        $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $id, 'hotm',1,$currentDate);
                        $reduceStock = $db->query('UPDATE products SET quantity = quantity - ? WHERE id = ?',1, $id );
                                           
                    }
                    $fetchProductAfterDec = $db->query('SELECT id,quantity,price FROM products where id=?', $id)->fetchArray();
                    if($fetchProductAfterDec["quantity"] == 0){
                        $setStatusOutOfStock = $db->query('UPDATE products SET status = ? WHERE id = ?','0',$id );
                    } 
                    $boxxtotal = $fetchProductAfterDec['price'];
                   
                    if($sub_key == 'delivery_address_id') {
                        $insertOrderItems = $db->query('INSERT INTO delivery_addresses (address_id, hamper_id, hamper_total) values (?,?,?)', $sub_val, $key, $boxxtotal);
                    }
                    if($sub_key == 'gift_message') {
                        $insertOrderItems = $db->query('INSERT INTO gift_messages (message, hamper_id) values (?,?)', $sub_val, $key);
                    }
                }
            }
            ob_start();
            include $root.'/logics/orderConfirmationEmail.php';
            $body = ob_get_clean();
            send_mail($Customer['email'],'orders@bespokeboxx.co.uk',"Order Confirmation","$body");
            send_mail('orders@bespokeboxx.co.uk','orders@bespokeboxx.co.uk',"Order Confirmation","$body");
            send_mail('shivampanday.sp@gmail.com','orders@bespokeboxx.co.uk',"New Order","$body");
            send_mail('rajsodha97@gmail.com','orders@bespokeboxx.co.uk',"New Order","$body");

            if(isset($_SESSION['discount'])){
                $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $_SESSION['discount'])->fetchArray();
                if($discount['discount_group'] == 'COMPETITION'){
                    $updateUsed = $db->query('UPDATE discount SET used = used + 1, status = 0 WHERE id = ?',  $discount['id']);
                }                
            }

            echo "inserted";
        } else {
            echo "failed";
        }
    }
    else if (isset($_SESSION["GUEST_LOGIN"]))
    {
        $GUEST = $db->query('SELECT id,email FROM user WHERE id = ?', $_SESSION['GUEST_LOGIN'])->fetchArray();
        $insertOrderDetails = $db->query('INSERT INTO order_details (order_no, user_id, payment_id, total, discount_applied, status,created_at) 
        values (?,?,?,?,?,?,?)', $order_no, $GUEST['id'], $paymentId, $total,$_SESSION['discount'] , '0',$currentDate);
        if ($insertOrderDetails->affectedRows() > 0) {
            $lastOrderId = $db->lastInsertID();
            $_SESSION['lastOrderId'] = $db->lastInsertID();
            foreach ($_SESSION['Cart'] as $key => $value) { 
                foreach ($value as $sub_key => $sub_val) {
                    if (is_array($sub_val)) { 
                        foreach ($sub_val as $k => $v) {
                            if($sub_key == "colour") {
                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'colour',$v,$currentDate);
                                
                            }
                            if($sub_key == "size") {

                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'size',$v,$currentDate);
                                $reduceStock = $db->query('UPDATE products SET quantity = quantity - ? WHERE id = ?',  $v, $k );
                                $fetchProductAfterDec = $db->query('SELECT id,quantity FROM products where id=?', $k)->fetchArray();
                                if($fetchProductAfterDec["quantity"] == 0){
                                    $setStatusOutOfStock = $db->query('UPDATE products SET status = ? WHERE id = ?','0',$k );
                                } 
                            }
                            if($sub_key == "filling") {
                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'filling',$v,$currentDate);
    
                            }
                            if($sub_key == "products") {
                                
                                $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $k, 'product',$v,$currentDate);
                                $reduceStock = $db->query('UPDATE products SET quantity = quantity - ? WHERE id = ?',$v, $k );
                                $fetchProductAfterDec = $db->query('SELECT id,quantity FROM products where id=?', $k)->fetchArray();
                                if($fetchProductAfterDec["quantity"] == 0){
                                    $setStatusOutOfStock = $db->query('UPDATE products SET status = ? WHERE id = ?','0',$k );
                                } 
                            }
                        }
                    } else {
                        $boxxtotal;
                        if($sub_key == 'total') {
                            $boxxtotal = $sub_val;
                        }
                        if($sub_key == 'delivery_address_id') {
                            $insertOrderItems = $db->query('INSERT INTO delivery_addresses (address_id, hamper_id, hamper_total) values (?,?,?)', $sub_val, $key,$boxxtotal);
                        }
                        if($sub_key == 'gift_message') {
                            $insertOrderItems = $db->query('INSERT INTO gift_messages (message, hamper_id) values (?,?)', $sub_val, $key);
                        }
                    }
                }
                        
            }
            foreach ($_SESSION['botmBoxx'] as $key => $value)
            {
                foreach ($value as $sub_key => $sub_val) {
                    $id;
                    if($sub_key == 'productid') {
                        $id = $sub_val;
                        $insertOrderItems = $db->query('INSERT INTO order_items (hamper_id, order_id, product_id, type, quantity,created_at) values (?,?,?,?,?,?)', $key, $lastOrderId, $id, 'hotm',1,$currentDate);
                        $reduceStock = $db->query('UPDATE products SET quantity = quantity - ? WHERE id = ?',1, $id );
                    }
                    $fetchProductAfterDec = $db->query('SELECT id,quantity,price FROM products where id=?', $id)->fetchArray();
                    if($fetchProductAfterDec["quantity"] == 0){
                        $setStatusOutOfStock = $db->query('UPDATE products SET status = ? WHERE id = ?','0',$id );
                    } 
                    $boxxtotal = $fetchProductAfterDec['price'];
                   
                    if($sub_key == 'delivery_address_id') {
                        $insertOrderItems = $db->query('INSERT INTO delivery_addresses (address_id, hamper_id, hamper_total) values (?,?,?)', $sub_val, $key,$boxxtotal);
                    }
                    if($sub_key == 'gift_message') {
                        $insertOrderItems = $db->query('INSERT INTO gift_messages (message, hamper_id) values (?,?)', $sub_val, $key);
                    }
                }
            }

            ob_start();
            include $root.'/logics/orderConfirmationEmail.php';
            $body = ob_get_clean();
            send_mail($GUEST['email'],'orders@bespokeboxx.co.uk',"Order Confirmation","$body");
            send_mail('orders@bespokeboxx.co.uk','orders@bespokeboxx.co.uk',"Order Confirmation","$body");
            send_mail('shivampanday.sp@gmail.com','orders@bespokeboxx.co.uk',"New Order","$body");
            send_mail('rajsodha97@gmail.com','orders@bespokeboxx.co.uk',"New Order","$body");

            if(isset($_SESSION['discount'])){
                $discount = $db->query('SELECT * FROM discount WHERE description = ? ', $_SESSION['discount'])->fetchArray();
                if($discount['discount_group'] == 'COMPETITION'){
                    $updateUsed = $db->query('UPDATE discount SET used = used + 1, status = 0 WHERE id = ?',  $discount['id']);
                }                
            }
            echo "inserted";
        } else {
            echo "failed";
        }
    }
}

if (isset($_GET['clear_cart']))
{
    clearCart();
    echo "cleared";

}

if (isset($_GET['clear_selection']))
{
    if($_GET['clear_selection'] == "Y"){
        unset($_SESSION['boxxEditId']);

        foreach($_SESSION['boxxproducts'] as $id=>$qty){
            $_SESSION['itemsLeft'][$id] -= $qty;
        }
        clearBoxx();
        echo "cleared";
    } else {
        
        $boxxrid = $_GET['clear_selection'];
        foreach($_SESSION['boxxproducts'] as $id=>$qty){
            $_SESSION['itemsLeft'][$id] -= $qty;
        }
        foreach ($_SESSION['Cart'] as $key => $value) {
            if($key == $boxxrid){
                unset($_SESSION['Cart'][$boxxrid]);
                $_SESSION['boxxQuantity']--;
                if($_SESSION['boxxQuantity'] == 0){
                    unset($_SESSION['boxxQuantity']);

                }

            }
            
        }
        
        clearBoxx();
        unset($_SESSION['boxxEditId']);

        echo "cleared";
    }
    

}

if (isset($_POST['discount_code']))
{
    $discount = $db->query('SELECT * FROM discount WHERE description = ? AND status = ? AND is_deleted = ?', $_POST['discount_code'], '1', '0')->fetchArray();
    if(count($discount) > 0){
        if($discount['discount_group'] == 'PROMO'){
            if(get_total($db) >= $discount['minimum_total']){
                $_SESSION['discount'] = $discount["description"];
                echo "valid";
            }else {
                echo "invalid";
            }
        } else if($discount['discount_group'] == 'COMPETITION'){
            if ($discount['used'] < 1 ){
                if(get_total($db) >= $discount['minimum_total']){
                    $_SESSION['discount'] = $discount["description"];
                    echo "valid";
                } else {
                    echo "invalid";
                }
            } else {
                echo "invalid";
            }
        }
    } else {
        echo "invalid";
    }
}

if(isset($_GET['check_cart_items'])) {
    if($_GET['check_cart_items'] == 'Y') {
        foreach($_SESSION['itemsLeft'] as $x=>$v) {
            $item = $db->query('SELECT id,quantity,price FROM products WHERE id = ?', $x)->fetchArray();
            foreach ($_SESSION['Cart'] as $key => $value) {
                if($item['quantity'] < $v){
                    $valueToReduce = $v - $item['quantity'];
                    foreach ($value as $sub_key => $sub_val) {
                        if (is_array($sub_val)) { 
                            foreach ($sub_val as $id => $qty) {
                                if($sub_key == "products") {
                                    if ($x == $id){
                                        $_SESSION['Cart'][$key][$sub_key][$id]--;
                                        $_SESSION['Cart'][$key]['total']-= $item['price'];
                                        $_SESSION['itemsLeft'][$id]--;
                                        if($_SESSION['Cart'][$key][$sub_key][$id] == 0 ){
                                            unset($_SESSION['Cart'][$key][$sub_key][$id]);     
                                        } 
                                        
                                    }
                                }
                            }
                        }
                    }
                    if($_SESSION['itemsLeft'][$x] == $item['quantity']){
                        if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) > 0){
                            unset($_SESSION['botmBoxx']);
                        } else if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) == 0){
                            clearCart();
                        }
                        echo "updated";
                        break;
                    }
                }
            }
            foreach ($_SESSION['botmBoxx'] as $key => $value) {
                if($item['quantity'] < $v){
                    foreach ($value as $sub_key => $sub_val) {
                        if($sub_key == "productid") {
                            if ($x == $sub_val){
                                $_SESSION['itemsLeft'][$x]--;
                                unset($_SESSION['botmBoxx'][$key]);  
                                $_SESSION['boxxQuantity']--;
                                
                           
                            }
                        }
                    }
                    if($_SESSION['itemsLeft'][$x] == $item['quantity']){
                        if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) > 0){
                            unset($_SESSION['botmBoxx']);
                        } else if(count($_SESSION['botmBoxx']) == 0 && count($_SESSION['Cart']) == 0){
                            clearCart();
                        }
                        echo "updated";
                        break;
                    }
                }
            }
        }
    }   
}

if(isset($_GET['section_selection'])){
    if($_GET['section_selection'] == 'Y'){
        if(isset($_SESSION['boxxcolour']) && !isset($_SESSION['boxxsize']) && !isset($_SESSION['boxxfilling']) && !isset($_SESSION['boxxproducts'])){
            echo "colourSet"; 
        } else if(isset($_SESSION['boxxcolour']) && isset($_SESSION['boxxsize']) && !isset($_SESSION['boxxfilling']) && !isset($_SESSION['boxxproducts'])){
            echo "sizeSet";
        } else if(isset($_SESSION['boxxcolour']) && isset($_SESSION['boxxsize']) && isset($_SESSION['boxxfilling']) && !isset($_SESSION['boxxproducts'])){
            echo "fillingSet";
        } 
    
    }
}

if(isset($_GET['hideCart']) == 'Y'){
    $_SESSION['sideCartVisible'] = false;

}

if(isset($_GET['change_guest']) == 'Y'){
    unset($_SESSION["GUEST_LOGIN"]);
    cleanseUselessUserData($db);
    echo "changeEmail";
}

?>
