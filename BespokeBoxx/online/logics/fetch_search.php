<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . "/helpers/config.php";
if (!$db = new mysqli($host, $user, $password, $db)) {
	die($db->connect_errno.' - '.$db->connect_error);
}
$arr = array();
if (!empty($_POST['keywords']) && strlen($_POST['keywords']) >= 1) {
	$keywords = $_POST['keywords'];
	$keywords = $db->real_escape_string($keywords);
    $sql = "SELECT id,name,description,image,price FROM products where name LIKE '%".$keywords."%' AND is_deleted = 0 AND status=1 AND id IN (SELECT product_id FROM products_to_category WHERE category_id!=3 AND category_id!=10 AND category_id!=11 AND category_id!=12) Limit 10";

	$result = $db->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) {
		while ($obj = $result->fetch_object()) {
			$arr[] = array('id' => $obj->id,'name' => $obj->name, 'description' => $obj->description,'image' => $obj->image,'price' => $obj->price);
		}
	}

}
echo json_encode($arr);

 ?>