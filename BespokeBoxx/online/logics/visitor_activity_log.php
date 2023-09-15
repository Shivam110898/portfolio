<?php 
// Get current page URL 
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
 
$user_current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']; 
 
// Get server related info 
$user_ip_address = $_SERVER['REMOTE_ADDR']; 
$referrer_url = !empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'/'; 
$user_agent = $_SERVER['HTTP_USER_AGENT']; 
$currentDate=date("Y-m-d H:i:s");

if(!isset($_COOKIE['_v'])){
    $insert = $db->query("INSERT INTO visitor_activity_logs (user_ip_address, user_agent, page_url, referrer_url,count,created_on) VALUES (?,?,?,?,?,?)",$user_ip_address, $user_agent,$user_current_url,$referrer_url,1,$currentDate);
} else {
    $visitor = $db->query('SELECT * FROM visitor_activity_logs where user_ip_address = ? AND user_agent = ?', $user_ip_address, $user_agent )->fetchArray();
    $updateCount = $db->query("UPDATE visitor_activity_logs SET count = count + 1 AND created_on=? where user_ip_address = ? AND user_agent = ?",$currentDate,$visitor['user_ip_address'], $visitor['user_agent'] );
}
?>