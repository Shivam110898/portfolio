<?php 
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . "/logics/DotEnv.php";

(new DotEnv($root . '/.env'))->load();

header('Content-Type: application/json');

try {
  echo json_encode(getenv('TEST_PUBLIC_API_KEY'));

} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
?>