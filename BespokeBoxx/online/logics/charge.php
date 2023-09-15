<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/Database.php";
require $root . "/helpers/config.php";
require $root . "/helpers/functions.php";

$db = new Database($host, $user, $password, $db);
require_once $root . "/vendor/autoload.php";
require_once $root . "/logics/DotEnv.php";

(new DotEnv($root . '/.env'))->load();

// This is your real test secret API key.
$testApiKey = getenv('TEST_SECRET_API_KEY');
\Stripe\Stripe::setApiKey($testApiKey);

header('Content-Type: application/json');

try {
  $profileResult;
  if (isset($_SESSION["CUSTOMER_LOGIN"])) {
    $profileResult = $db->query('SELECT email FROM user where email = ?', $_SESSION['CUSTOMER_LOGIN'])->fetchArray();
    
  } else if(isset($_SESSION["GUEST_LOGIN"])){
      $profileResult = $db->query('SELECT email FROM user where id = ?', $_SESSION['GUEST_LOGIN'])->fetchArray();
  }

     
  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => get_grand_total($db)*100,
    'currency' => 'gbp',
    'description' => "BespokeBoxx",
    'receipt_email' => $profileResult['email'],
    'automatic_payment_methods' => [
      'enabled' => true,
    ],
  ]);

  $output = [
    'clientSecret' => $paymentIntent->client_secret,
  ];

  echo json_encode($output);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}